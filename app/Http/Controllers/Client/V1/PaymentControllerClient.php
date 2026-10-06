<?php

namespace App\Http\Controllers\Client\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Shetabit\Multipay\Invoice;

class PaymentControllerClient extends Controller
{
    public function start(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            return ApiResponseClass::errorResponse('forbidden', 'this action is unauthorized', 422);
        }
        if ($reservation->status !== 'pending') {
            return ApiResponseClass::errorResponse('invalid_status', 'order status is not pending', 422);
        }
        if ($reservation->total_price <= 0) {
            return ApiResponseClass::errorResponse('invalid_amount', 'order Price must be grater the zero', 422);
        }
        $existingPaid = Payment::query()->where('reservation_id',$reservation->id)->first();

        if (!$existingPaid)
        {
            return ApiResponseClass::errorResponse('already-paid','reservation already paid',422);
        }

        DB::beginTransaction();
        try {

            $payment = Payment::query()->create([
               'amount' => $reservation->total_price,
                'user_id' => $reservation->user_id,
                'reservation_id' => $reservation->id,
                'payment_gateway' => 'zibal'
            ]);
            $invoice = (new Invoice())->amount($reservation->total_price);
            $callback = route('payment.callback',['payment' => $payment->id]);
            $paymentRequest = \Shetabit\Payment\Facade\Payment::via('zibal')
                ->callbackUrl($callback)
                ->purchase($invoice,function ($driver,$transactionId) use ($payment){
                    $payment->transaction_id = $transactionId;
                    $payment->save();
                })->pay();
            DB::commit();
            $redirectUrl = json_decode($paymentRequest->toJson(),true);
            return ApiResponseClass::apiResponse(true, 'payment started.', [
                'reservation_id' => $reservation->id,
                'payment' => $payment->id,
                'amount' => $payment->amount,
                'gateway' => $payment->payment_gateway,
                'redirect' => $redirectUrl,
            ], 200);

        } catch (\Exception $exception) {

            DB::rollBack();
            return ApiResponseClass::errorResponse('server_error', $exception->getMessage(), 500);
        }
    }
    public function callback(Payment $payment, Request $request)
    {
        if ($payment->status === 'paid') {
            return ApiResponseClass::apiResponse(true, 'payment already verified', [
                'reservation_id' => $payment->reservation_id,
                'payment_id' => $payment->id,
                'status' => $payment->status,
            ], 200);
        }

        if (!$payment->transaction_id) {
            return ApiResponseClass::error('invalid_payment', 'transaction_id not found', 422);

        }
        $reservationId = $payment->reservation_id;
        $reservation = Reservation::query()->where('id',$reservationId)->first();

        if (!$reservation) {
            return ApiResponseClass::error('reservation_not_found', 'Related reservation not found', 422);
        }
        try {
            $receipt = \Shetabit\Payment\Facade\Payment::via('zibal')
                ->amount($payment->amount)
                ->transactionId($payment->transaction_id)
                ->verify();

            $payment->update([
                'status' => 'completed'
            ]);

            $reservation->update([
                'status' => 'completed'
            ]);

            $refId = $receipt->getReferenceId();

            return ApiResponseClass::apiResponse(true, 'payment successful.', [
                'reservation_id' => $reservation->id,
                'payment_id' => $payment->id,
                'status' => $payment->status,
                'reservation_status' => $reservation->status,
                'refId' => $refId,

            ], 200);

        } catch (\Exception $exception) {
            $payment->update([
                'status' => 'cancelled'
            ]);

            return ApiResponseClass::error('payment_failed', $exception->getMessage(), 500);

        }

    }

}
