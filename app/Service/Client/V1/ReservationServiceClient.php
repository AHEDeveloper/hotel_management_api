<?php

namespace App\Service\Client\V1;

use Illuminate\Support\Facades\Validator;

class ReservationServiceClient
{
    public static function validation($request)
    {
        return Validator::make($request->all(),[
//            'user_id' => 'required|exists:users,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
//            'total_price' => 'required|numeric|min:0',
            'status' => 'nullable|string|in:pending,confirmed,cancelled',
        ], [
            'user_id.required' => 'انتخاب کاربر الزامی است.',
            'user_id.exists' => 'کاربر انتخاب‌شده وجود ندارد.',

            'check_in.required' => 'تاریخ ورود الزامی است.',
            'check_in.date' => 'تاریخ ورود معتبر نیست.',
            'check_in.after_or_equal' => 'تاریخ ورود نمی‌تواند قبل از امروز باشد.',

            'check_out.required' => 'تاریخ خروج الزامی است.',
            'check_out.date' => 'تاریخ خروج معتبر نیست.',
            'check_out.after' => 'تاریخ خروج باید بعد از تاریخ ورود باشد.',

            'guests.required' => 'تعداد مهمانان الزامی است.',
            'guests.integer' => 'تعداد مهمانان باید عدد باشد.',
            'guests.min' => 'حداقل تعداد مهمانان باید ۱ نفر باشد.',

            'total_price.required' => 'قیمت کل الزامی است.',
            'total_price.numeric' => 'قیمت کل باید به صورت عددی باشد.',
            'total_price.min' => 'قیمت کل نمی‌تواند منفی باشد.',

            'status.string' => 'وضعیت باید به صورت متن باشد.',
            'status.in' => 'وضعیت انتخاب‌شده معتبر نیست.',
        ]);
    }
}
