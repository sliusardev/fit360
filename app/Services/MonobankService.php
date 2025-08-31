<?php

namespace App\Services;

use App\Enums\PaymentStatusEnum;
use App\Models\Company;
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

        $amountMinor = 100;

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
        $content = $request->getContent();
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('Monobank webhook: invalid JSON', ['content' => $content]);
            return response()->json(['status' => 'error', 'message' => 'invalid json'], 400);
        }

        // Verify signature if present
//        $token = config('services.monobank.token');
        $receivedSign = $request->header('X-Sign', '');

        if ($receivedSign !== '') {
            $verified = $this->verifyMonobankSignature($content, $receivedSign);

            if (!$verified) {
                Cache::forget('mono_merchant_pubkey_pem');
                $verified = $this->verifyMonobankSignature($content, $receivedSign);
            }

            if (!$verified) {
                Log::warning('Monobank webhook: invalid ECDSA signature', ['x_sign' => $receivedSign]);
            }
        } else {
            Log::info('Monobank webhook: no X-Sign header');
        }

//        if (!empty($receivedSign)) {
//            $expected = base64_encode(hash_hmac('sha256', $content, $token, true));
//            if (!hash_equals($expected, $receivedSign)) {
//                Log::warning('Monobank webhook: invalid signature', [
//                    'expected' => $expected,
//                    'received' => $receivedSign,
//                ]);
//                // Continue but mark as suspicious
//            }
//        } else {
//            Log::info('Monobank webhook: no signature header provided');
//        }

        Log::info('Monobank webhook payload', $data);

        $status = $this->mapStatus($data);
        $invoiceId = $data['invoiceId'] ?? null;

        if (!$invoiceId) {
            Log::error('Monobank webhook: missing invoiceId', $data);
            return response()->json(['status' => 'error', 'message' => 'missing invoiceId'], 400);
        }

        $payment = Payment::query()->where('invoice_id', $invoiceId)->first();

        if ($payment) {
            $payment->update([
                'status' => $status,
                'payload' => $data,
            ]);
        } else {
            Log::warning('Monobank webhook: payment not found', ['invoiceId' => $invoiceId]);
        }

        return response()->json(['status' => 'ok']);
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

    private function verifyMonobankSignature(string $rawBody, string $xSignBase64): bool
    {
        try {
            $pem = Cache::remember('mono_merchant_pubkey_pem', 3600, function () {
                $resp = Http::withHeaders([
                    'X-Token' => config('services.monobank.token'),
                    'Accept'  => 'application/json',
                ])->get('https://api.monobank.ua/api/merchant/pubkey');

                if (!$resp->ok()) {
                    throw new \RuntimeException('Failed to fetch Monobank pubkey');
                }
                return base64_decode($resp->body());
            });

            if (!$pem) return false;

            $publicKey = openssl_pkey_get_public($pem);
            if ($publicKey === false) return false;

            $signature = base64_decode($xSignBase64, true);
            if ($signature === false) return false;

            // У PHP для ECDSA достатньо SHA256 – OpenSSL сам визначає тип ключа (EC)
            return openssl_verify($rawBody, $signature, $publicKey, OPENSSL_ALGO_SHA256) === 1;
        } catch (\Throwable $e) {
            Log::error('Monobank signature verification error', ['e' => $e->getMessage()]);
            return false;
        }
    }
}

