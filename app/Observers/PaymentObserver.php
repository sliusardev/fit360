<?php

namespace App\Observers;

use App\Enums\MembershipsDurationTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Membership;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PaymentObserver
{
    /**
     * Handle the Payment "updated" event.
     */
    public function updated(Payment $payment): void
    {
        Log::info('membership status', [
            $payment->isDirty('status'),
            $payment->status,
            PaymentStatusEnum::PAID->value,
            PaymentStatusEnum::PAID->value === $payment->status,
            PaymentStatusEnum::PAID === $payment->status,
        ]);
        // Check if payment status changed to PAID
        if ($payment->isDirty('status') && $payment->status === PaymentStatusEnum::PAID->value) {
            $this->handleSuccessfulPayment($payment);
        }
    }

    /**
     * Handle successful payment and activate membership if applicable
     */
    private function handleSuccessfulPayment(Payment $payment): void
    {
        // Check if payment is for a membership
        if ($payment->payable_type === 'App\Models\Membership') {
            $membership = Membership::find($payment->payable_id);

            if (!$membership) {
                Log::warning('Membership not found for payment', ['payment_id' => $payment->id, 'membership_id' => $payment->payable_id]);
                return;
            }

            if (!$payment->user_id) {
                Log::warning('Payment has no user', ['payment_id' => $payment->id]);
                return;
            }

            // Calculate dates based on membership type
            $startDate = Carbon::now();
            $endDate = null;
            $visitLimit = null;

            if ($membership->duration_type === MembershipsDurationTypeEnum::UNLIMITED) {
                // For unlimited memberships, calculate end date based on duration_days
                $endDate = Carbon::now()->addDays($membership->duration_days);
            } elseif ($membership->duration_type === MembershipsDurationTypeEnum::VISITS) {
                // For visit-based memberships, set visit limit
                $visitLimit = $membership->visit_limit;
            }

            // Check if user already has this membership
            $existingMembership = $payment->user->memberships()
                ->wherePivot('membership_id', $membership->id)
                ->wherePivot('is_enabled', true)
                ->wherePivot('end_date', '>=', Carbon::now())
                ->first();

            if ($existingMembership) {
                // Extend existing membership
                $currentEndDate = Carbon::parse($existingMembership->pivot->end_date);

                if ($membership->duration_type === MembershipsDurationTypeEnum::UNLIMITED) {
                    $newEndDate = $currentEndDate->addDays($membership->duration_days);
                    $payment->user->memberships()->updateExistingPivot($membership->id, [
                        'end_date' => $newEndDate,
                    ]);
                } else {
                    // For visit-based, add visits
                    $currentVisits = $existingMembership->pivot->visit_limit ?? 0;
                    $payment->user->memberships()->updateExistingPivot($membership->id, [
                        'visit_limit' => $currentVisits + $membership->visit_limit,
                    ]);
                }

                Log::info('Extended existing membership', [
                    'user_id' => $payment->user_id,
                    'membership_id' => $membership->id,
                    'payment_id' => $payment->id
                ]);
            } else {
                // Attach new membership to user
                $payment->user->memberships()->attach($membership->id, [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'visit_limit' => $visitLimit,
                    'is_enabled' => true,
                ]);

                Log::info('Activated new membership', [
                    'user_id' => $payment->user_id,
                    'membership_id' => $membership->id,
                    'payment_id' => $payment->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'visit_limit' => $visitLimit,
                ]);
            }

            // Optionally send notification to user
            if (method_exists($payment->user, 'sendMessageToTelegram')) {
                try {
                    $message = "✅ Ваш абонемент '{$membership->name}' успішно активовано!\n";
                    if ($endDate) {
                        $message .= "Дійсний до: " . $endDate->format('d.m.Y');
                    }
                    if ($visitLimit) {
                        $message .= "Кількість відвідувань: {$visitLimit}";
                    }
                    $payment->user->sendMessageToTelegram($message);
                } catch (\Exception $e) {
                    Log::warning('Failed to send Telegram notification', ['error' => $e->getMessage()]);
                }
            }
        }
    }
}

