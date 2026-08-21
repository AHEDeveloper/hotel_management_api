<?php

namespace App\Service\Admin\V1;

use Illuminate\Support\Facades\Validator;

class RoomTypeAdmin
{
    public static function validation($request)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'min:2',
                    'max:100',
                ],

                'description' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],

                'capacity' => [
                    'required',
                    'integer',
                    'min:1',
                    'max:100',
                ],

                'price_per_night' => [
                    'required',
                    'integer',
                    'min:0',
                ],
            ],
            [
                'name.required' => 'وارد کردن نام نوع اتاق الزامی است.',
                'name.string' => 'نام نوع اتاق باید به صورت متن باشد.',
                'name.min' => 'نام نوع اتاق باید حداقل ۲ کاراکتر باشد.',
                'name.max' => 'نام نوع اتاق نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.',

                'description.string' => 'توضیحات باید به صورت متن باشد.',
                'description.max' => 'توضیحات نمی‌تواند بیشتر از ۱۰۰۰ کاراکتر باشد.',

                'capacity.required' => 'وارد کردن ظرفیت اتاق الزامی است.',
                'capacity.integer' => 'ظرفیت باید یک عدد صحیح باشد.',
                'capacity.min' => 'ظرفیت اتاق باید حداقل ۱ نفر باشد.',
                'capacity.max' => 'ظرفیت اتاق نمی‌تواند بیشتر از ۱۰۰ نفر باشد.',

                'price_per_night.required' => 'وارد کردن قیمت هر شب الزامی است.',
                'price_per_night.integer' => 'قیمت هر شب باید به صورت عدد صحیح باشد.',
                'price_per_night.min' => 'قیمت هر شب نمی‌تواند منفی باشد.',
            ]
        );
    }
}
