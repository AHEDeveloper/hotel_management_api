<?php

namespace App\Service\Admin\V1;

use Illuminate\Support\Facades\Validator;

class RoomTypeService
{
    public static function validationStore($request)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'capacity' => ['required', 'integer', 'min:1'],
                'price_per_night' => ['required', 'integer', 'min:0'],
            ],
            [
                'name.required' => 'وارد کردن نام نوع اتاق الزامی است.',
                'name.string' => 'نام نوع اتاق باید به صورت متن باشد.',
                'name.max' => 'نام نوع اتاق نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

                'description.string' => 'توضیحات باید به صورت متن باشد.',

                'capacity.required' => 'وارد کردن ظرفیت الزامی است.',
                'capacity.integer' => 'ظرفیت باید به صورت عدد صحیح باشد.',
                'capacity.min' => 'ظرفیت نمی‌تواند کمتر از ۱ باشد.',

                'price_per_night.required' => 'وارد کردن قیمت هر شب الزامی است.',
                'price_per_night.integer' => 'قیمت هر شب باید به صورت عدد صحیح باشد.',
                'price_per_night.min' => 'قیمت هر شب نمی‌تواند کمتر از ۰ باشد.',
            ]
        );
    }

    public static function validationUpdate($request)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => ['string', 'max:255'],
                'description' => ['nullable', 'string'],
                'capacity' => ['integer', 'min:1'],
                'price_per_night' => ['integer', 'min:0'],
            ],
            [
                'name.string' => 'نام نوع اتاق باید به صورت متن باشد.',
                'name.max' => 'نام نوع اتاق نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
                'description.string' => 'توضیحات باید به صورت متن باشد.',
                'capacity.integer' => 'ظرفیت باید به صورت عدد صحیح باشد.',
                'capacity.min' => 'ظرفیت نمی‌تواند کمتر از ۱ باشد.',
                'price_per_night.integer' => 'قیمت هر شب باید به صورت عدد صحیح باشد.',
                'price_per_night.min' => 'قیمت هر شب نمی‌تواند کمتر از ۰ باشد.',
            ]
        );
    }
}
