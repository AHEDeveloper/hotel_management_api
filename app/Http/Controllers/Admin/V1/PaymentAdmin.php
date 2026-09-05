<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Service\Admin\V1\PaymentService;
use Illuminate\Http\Request;

class PaymentAdmin extends Controller
{
    public function index()
    {
        $payment = Payment::query()->paginate(2);
        $items = collect($payment->items())->map(function ($item){
           return[
               $this->transformPayment($item)
           ] ;
        });
        return ApiResponseClass::apiResponse(true,'Payment retrieved successfully',[
            'items' => $items,
            'meta' => [
                'total' => $payment->total(),
                'current_page' => $payment->currentPage(),
                'per_page' => $payment->perPage(),
                'last_page' => $payment->lastPage(),
            ]
        ],200);
    }

    public function show(Payment $payment)
    {
        $room = Payment::find($payment->id);
        if (!$room) {
            return ApiResponseClass::errorResponse('not_found', 'Payment not found.', 404);
        }
    }

    public function update(Request $request,payment $payment)
    {
        $reservationFind = payment::query()->find($payment->id);
        if (!$reservationFind) {
            return ApiResponseClass::errorResponse('not_found', 'Reservation not found.', 404);
        }

        $validation = PaymentService::validationUpdate($request);
        if ($validation->fails()) {
            return ApiResponseClass::apiResponse(false, 'validation is fails', $validation->errors(), 422);
        }
        $payment->update($request->all());
        return ApiResponseClass::apiResponse(true,'payment updated successfully',$this->transformPayment($payment),200);
    }

    public function destroy(Payment $payment)
    {
        $reservationFind = Payment::query()->find($payment->id);
        if (!$reservationFind) {
            return ApiResponseClass::errorResponse('not_found', 'Payment not found.', 404);
        }
        return ApiResponseClass::apiResponse(true,'Payment deleted successfully',$payment->delete(),200);
    }

    public function transformPayment($item)

    {
        return[
            'id' => $item->id,
            'amount' => $item->amount,
            'status' => $item->status,
            'transaction_id' => $item->transaction_id,
            'paid_at' => $item->transaction_id,
        ];
    }
}
