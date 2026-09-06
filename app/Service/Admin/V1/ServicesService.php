<?php

namespace App\Service\Admin\V1;

use Illuminate\Support\Facades\Validator;

class ServicesService
{
    public static function validationStore($request)
    {
        return Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'وارد کردن نام الزامی است.',
            'name.string' => 'نام باید به صورت متن باشد.',
            'name.max' => 'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'description.string' => 'توضیحات باید به صورت متن باشد.',

            'price.required' => 'وارد کردن قیمت الزامی است.',
            'price.numeric' => 'قیمت باید به صورت عدد باشد.',
            'price.min' => 'قیمت نمی‌تواند کمتر از صفر باشد.',
        ]);
    }

    public static function validationUpdate($request)
    {
        return Validator::make($request->all(),[
            'name'        => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
            'price'       => 'sometimes|numeric|min:0',
        ], [
            'name.string' => 'نام باید به صورت متنی باشد.',
            'name.max'    => 'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'description.string' => 'توضیحات باید به صورت متنی باشد.',

            'price.numeric' => 'قیمت باید یک مقدار عددی باشد.',
            'price.min'     => 'قیمت نمی‌تواند منفی باشد.',
        ]);
    }


}
