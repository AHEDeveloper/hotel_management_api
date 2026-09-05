<?php

namespace App\Service\Admin\V1;

use Illuminate\Support\Facades\Validator;

class PaymentService
{
    public static function validationUpdate($request)
    {
        return Validator::make($request->all(),[
            'reservation_id' => 'sometimes|exists:reservations,id',
            'amount'         => 'sometimes|numeric|min:0',
            'status'         => 'sometimes|in:pending,paid,failed,cancelled,refunded',
            'transaction_id' => 'sometimes|nullable|string|max:255|unique:payments,transaction_id,' . $payment->id,
            'paid_at'        => 'sometimes|nullable|date',
        ], [
            'reservation_id.exists' => 'رزرو انتخاب شده وجود ندارد.',

            'amount.numeric' => 'مبلغ باید یک مقدار عددی باشد.',
            'amount.min'     => 'مبلغ نمی‌تواند منفی باشد.',

            'status.in' => 'وضعیت پرداخت انتخاب شده معتبر نیست.',

            'transaction_id.string' => 'شناسه تراکنش باید به صورت متنی باشد.',
            'transaction_id.max'    => 'شناسه تراکنش نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
            'transaction_id.unique' => 'این شناسه تراکنش قبلاً ثبت شده است.',

            'paid_at.date' => 'تاریخ پرداخت معتبر نیست.',
        ]);
    }
}
