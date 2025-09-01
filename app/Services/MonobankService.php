<?php

namespace App\Services;

use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MonobankService
{
    public function createInvoice(Payment $payment, string $productName, float $amount, string $currency): array
    {
        $token = config('services.monobank.token');
        $baseUrl = rtrim(config('services.monobank.base_url'), '/');
        $currencyCode = $this->mapCurrencyCode($currency);

        $amountMinor = (int) round($amount * 100);
        $reference = 'mono_' . uniqid();

        $payload = [
            'amount' => $amountMinor,
            'ccy' => $currencyCode,
            'merchantPaymInfo' => [
                'reference' => $reference,
                'destination' => $productName,
                'basketOrder' => [
                    [
                        'name' => $productName,
                        'qty' => 1,
                        'sum' => $amountMinor,
                    ],
                ],
            ],
            'redirectUrl' => route('monobank.return', $payment->id),
            'webHookUrl' => route('monobank.webhook'),
            'validity' => 86400,
        ];

        try {
            $response = Http::withHeaders([
                'X-Token' => $token,
                'Content-Type' => 'application/json',
            ])->post($baseUrl . '/api/merchant/invoice/create', $payload);

            if (!$response->successful()) {
                Log::error('Monobank invoice create failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return ['error' => 'Failed to create invoice'];
            }

            $data = $response->json();
            Log::info('Monobank invoice created', $data ?? []);

            return [
                'invoiceId' => $data['invoiceId'] ?? null,
                'pageUrl' => $data['pageUrl'] ?? null,
                'payload' => $payload,
            ];
        } catch (\Throwable $e) {
            Log::error('Monobank invoice exception: ' . $e->getMessage());
            return ['error' => 'Exception during invoice creation'];
        }
    }

    public function handleWebhook(Request $request): JsonResponse
    {
        // 1) Сирий body — важливо не перекодувати!
        $body = $request->getContent();
        $data = json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Monobank webhook: invalid JSON', ['content' => $body]);
            return response()->json(['status' => 'error', 'message' => 'invalid json'], 400);
        }

        // 2) Перевірка ECDSA X-Sign
        $xSign = (string) ($request->header('X-Sign') ?? '');
        if ($xSign === '') {
            Log::warning('Monobank webhook: no X-Sign header');
            return response()->json(['status' => 'error', 'message' => 'missing signature'], 400);
        }

        if (!$this->verifyMonobankSignature($body, $xSign)) {
            // Спробуємо один раз оновити ключ (на випадок ротації) і перевірити знову
            Cache::forget('monobank:pubkey:pem');
            if (!$this->verifyMonobankSignature($body, $xSign)) {
                Log::warning('Monobank webhook: invalid signature after refresh');
                // Повертаємо 400 — monobank зробить до 3 ретраїв, як у доках.
                return response()->json(['status' => 'error', 'message' => 'invalid signature'], 400);
            }
        }

        Log::info('Monobank webhook payload', $data);

        $status   = $this->mapStatus($data); // твоя логіка мапінгу
        $invoiceId = $data['invoiceId'] ?? ($data['orderReference'] ?? null);
        if (!$invoiceId) {
            Log::error('Monobank webhook: missing invoiceId', $data);
            return response()->json(['status' => 'error', 'message' => 'missing invoiceId'], 400);
        }

        $payment = Payment::query()->where('invoice_id', $invoiceId)->first();

        if ($payment) {
            $payment->update([
                'status'  => $status,
                'payload' => $data,
            ]);
        } else {
            Log::warning('Monobank webhook: payment not found', ['invoiceId' => $invoiceId]);
        }

        return response()->json(['status' => 'ok']);
    }

    private function fetchMonobankPem(): string
    {
        $baseUrl = rtrim(config('services.monobank.base_url', 'https://api.monobank.ua'), '/');
        $token   = config('services.monobank.token');

        $resp = Http::withHeaders(['X-Token' => $token])
            ->get($baseUrl . '/api/merchant/pubkey');

        if (!$resp->ok()) {
            Log::error('Monobank pubkey fetch failed', ['status' => $resp->status(), 'body' => substr($resp->body(), 0, 120)]);
            throw new \RuntimeException('pubkey fetch failed');
        }

        $raw = trim($resp->body());

        // Випадок 1: Monobank вже віддав PEM (рідко, але перестрахуємось)
        if (str_starts_with($raw, '-----BEGIN ')) {
            return $raw;
        }

        // Випадок 2: Monobank віддав base64 від PEM (як у доках)
        $pem = base64_decode($raw, false); // НЕ strict!
        if ($pem !== false && str_contains($pem, 'BEGIN PUBLIC KEY')) {
            return $pem;
        }

        // Випадок 3: раптом JSON (помилка/проксі/неочікувано)
        $json = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $maybe = $json['pubkey'] ?? $json['key'] ?? $json['data'] ?? null;
            if ($maybe) {
                $pem = base64_decode($maybe, false);
                if ($pem !== false && str_contains($pem, 'BEGIN PUBLIC KEY')) {
                    return $pem;
                }
            }
        }

        Log::error('Monobank pubkey invalid format', ['preview' => substr($raw, 0, 120)]);
        throw new \RuntimeException('invalid pubkey format');
    }


    private function verifyMonobankSignature(string $body, string $xSignBase64): bool
    {
        try {
            $pem = Cache::remember('monobank:pubkey:pem', 86400, fn() => $this->fetchMonobankPem());

            $publicKey = openssl_pkey_get_public($pem);
            if ($publicKey === false) {
                Log::error('Monobank pubkey PEM not accepted by OpenSSL');
                return false;
            }

            $signature = base64_decode($xSignBase64, false);
            if ($signature === false) {
                Log::warning('Monobank X-Sign is not base64');
                return false;
            }

            return openssl_verify($body, $signature, $publicKey, OPENSSL_ALGO_SHA256) === 1;
        } catch (\Throwable $e) {
            Log::error('Monobank signature verify error', ['e' => $e->getMessage()]);
            return false;
        }
    }


    protected function mapCurrencyCode(string $currency): int
    {
        return match (strtoupper($currency)) {
            'UAH' => 980,
            'USD' => 840,
            default => 980,
        };
    }

    protected function mapStatus(array $data): PaymentStatusEnum
    {
        $status = $data['status'] ?? ($data['invoiceStatus'] ?? '');
        $status = strtolower((string) $status);

        return match ($status) {
            'success', 'paid' => PaymentStatusEnum::PAID,
            'failure', 'failed', 'declined', 'expired' => PaymentStatusEnum::FAILED,
            'reversed', 'refund' => PaymentStatusEnum::REFUNDED,
            default => PaymentStatusEnum::PENDING,
        };
    }
}
