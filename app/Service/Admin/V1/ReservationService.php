<?php

namespace App\Service\Admin\V1;

use Illuminate\Support\Facades\Validator;

class ReservationService
{
    public static function validationUpdate($request)
    {
        return Validator::make($request->all(),[
            'user_id'    => 'sometimes|exists:users,id',
            'check_in'   => 'sometimes|date',
            'check_out'  => 'sometimes|date|after_or_equal:check_in',
            'guests'     => 'sometimes|integer|min:1',
            'total_price' => 'sometimes|numeric|min:0',
            'status'     => 'sometimes|in:pending,confirmed,cancelled',
        ], [
            'user_id.exists' => 'کاربر انتخاب شده معتبر نیست.',

            'check_in.date' => 'تاریخ ورود معتبر نیست.',

            'check_out.date' => 'تاریخ خروج معتبر نیست.',
            'check_out.after_or_equal' => 'تاریخ خروج باید بعد از یا برابر با تاریخ ورود باشد.',

            'guests.integer' => 'تعداد مهمانان باید عدد باشد.',
            'guests.min' => 'تعداد مهمانان باید حداقل ۱ نفر باشد.',

            'total_price.numeric' => 'مبلغ کل باید عددی باشد.',
            'total_price.min' => 'مبلغ کل نمی‌تواند منفی باشد.',

            'status.in' => 'وضعیت انتخاب شده معتبر نیست.',
        ]);
    }
}
