<?php

namespace App\Http\Controllers\Billing;

use App\Enums\CurrenciesEnum;
use App\Enums\PaymentProviderEnum;
use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\MonobankService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class MonobankController extends Controller
{
    public function pay(Request $request)
    {
        $amount = $request->input("amount");
        $payableType = $request->input('payable_type');
        $payableId = $request->input('payable_id');
        $currency = CurrenciesEnum::UAH->value;

        $productName = $request->input('name');

        $paymentData = [
            'name' => $productName
        ];

        $order = [
            'name' => $productName,
        ];

        $payment = resolve(PaymentService::class)->init(
            PaymentProviderEnum::MONOBANK->value,
            $paymentData,
            (int) round($amount),
            $currency,
            $order,
            $payableType,
            $payableId
        );

        $invoice = resolve(MonobankService::class)
            ->createInvoice($payment, $productName, $amount, $currency);

        if (isset($invoice['error']) || empty($invoice['invoiceId']) || empty($invoice['pageUrl'])) {
            return back()->with('error', __('dashboard.failed_process_payment'));
        }

        $paymentData = [
            'invoice_id' => $invoice['invoiceId'],
            'pageUrl' => $invoice['pageUrl'],
            'name' => $productName,
        ];

        $payment->update([
            'invoice_id' => $invoice['invoiceId'],
            'payload' => $paymentData
        ]);

        return redirect()->away($invoice['pageUrl']);
    }

    public function webhook(Request $request)
    {
        return resolve(MonobankService::class)->handleWebhook($request);
    }

    public function return($paymentId)
    {
        $payment = Payment::query()->where('id', $paymentId)->with(['activity', 'payable'])->first();

        if (!$payment) {
            return response()->redirectToRoute('activity')->with('error', 'Платіж не знайдено.');
        }

        $status = trans('dashboard.pending');

        if ($payment->status === PaymentStatusEnum::PAID->value) {
            $status = trans('dashboard.paid');
        }

        if ($payment->status === PaymentStatusEnum::FAILED->value) {
            $status = trans('dashboard.failed');
        }

        if ($payment->payable_type === 'App\Models\Activity' && $payment->activity) {
            return response()->redirectToRoute('activity.show', ['id' => $payment->activity->id])
                ->with('info', 'Статус платежу: ' . $status);
        }

        if ($payment->payable_type === 'App\Models\Membership' && $payment->payable) {
            return response()->redirectToRoute('memberships.show', ['id' => $payment->payable->id])
                ->with('info', 'Статус платежу: ' . $status);
        }

        return response()->redirectToRoute('home')->with('info', $status);
    }
}
