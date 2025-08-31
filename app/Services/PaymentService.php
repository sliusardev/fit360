<?php

namespace App\Services;


use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function init(
        string $provider,
        array $paymentData,
        int $amount,
        string $currency,
        array $order,
        string $payableType,
        int $payableId
    ) {
        try {
            return Payment::query()->create([
                'provider' => $provider,
                'invoice_id' => $paymentData['invoice_id'] ?? '',
                'amount' => $amount,
                'currency' => $currency,
                'status' => PaymentStatusEnum::CREATED,
                'payload' => $paymentData,
                'user_id' => auth()->id(),
                'order' => $order,
                'payable_type' => $payableType,
                'payable_id' => $payableId,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to save payment: ' . $e->getMessage());
        }

        return null;
    }
}
