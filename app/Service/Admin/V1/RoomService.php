<?php

namespace App\Service\Admin\V1;

use Illuminate\Support\Facades\Validator;

class RoomService
{
    public static function validationStore($request)
    {
        return Validator::make(
            $request->all(),
            [
                'room_type_id' => ['required', 'integer', 'exists:room_types,id'],
                'room_number' => ['required', 'string', 'max:255', 'unique:rooms,room_number'],
                'floor' => ['required', 'integer', 'min:0'],
                'status' => ['required', 'string', 'in:available,maintenance'],
            ],
            [
                'room_type_id.required' => 'انتخاب نوع اتاق الزامی است.',
                'room_type_id.integer' => 'شناسه نوع اتاق باید به صورت عدد صحیح باشد.',
                'room_type_id.exists' => 'نوع اتاق انتخاب‌شده وجود ندارد.',

                'room_number.required' => 'وارد کردن شماره اتاق الزامی است.',
                'room_number.string' => 'شماره اتاق باید به صورت متن باشد.',
                'room_number.max' => 'شماره اتاق نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
                'room_number.unique' => 'این شماره اتاق قبلاً ثبت شده است.',

                'floor.required' => 'وارد کردن طبقه الزامی است.',
                'floor.integer' => 'طبقه باید به صورت عدد صحیح باشد.',
                'floor.min' => 'شماره طبقه نمی‌تواند کمتر از ۰ باشد.',

                'status.required' => 'وارد کردن وضعیت اتاق الزامی است.',
                'status.string' => 'وضعیت اتاق باید به صورت متن باشد.',
                'status.in' => 'وضعیت انتخاب‌شده برای اتاق معتبر نیست.',
            ]
        );
    }

    public static function validationSUpdate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'room_type_id' => [ 'integer', 'exists:room_types,id'],
                'room_number' => [ 'string', 'max:255', 'unique:rooms,room_number'],
                'floor' => [ 'integer', 'min:0'],
                'status' => [ 'string', 'in:available,maintenance'],
            ],
            [
                'room_type_id.integer' => 'شناسه نوع اتاق باید به صورت عدد صحیح باشد.',
                'room_type_id.exists' => 'نوع اتاق انتخاب‌شده وجود ندارد.',

                'room_number.string' => 'شماره اتاق باید به صورت متن باشد.',
                'room_number.max' => 'شماره اتاق نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
                'room_number.unique' => 'این شماره اتاق قبلاً ثبت شده است.',

                'floor.integer' => 'طبقه باید به صورت عدد صحیح باشد.',
                'floor.min' => 'شماره طبقه نمی‌تواند کمتر از ۰ باشد.',

                'status.string' => 'وضعیت اتاق باید به صورت متن باشد.',
                'status.in' => 'وضعیت انتخاب‌شده برای اتاق معتبر نیست.',
            ]
        );
    }

}
