<?php

namespace App\Service\Admin\V1;

use Illuminate\Support\Facades\Validator;

class AdminService
{
    public static function validationStore($request)
    {
        return Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'وارد کردن نام الزامی است.',
            'name.string' => 'نام باید به صورت متن باشد.',
            'name.max' => 'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'email.required' => 'وارد کردن ایمیل الزامی است.',
            'email.email' => 'فرمت ایمیل وارد شده صحیح نیست.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',

            'password.required' => 'وارد کردن رمز عبور الزامی است.',
            'password.string' => 'رمز عبور باید به صورت متن باشد.',
            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
        ]);
    }

    public static function validationUpdate($request)
    {
       return Validator::make($request->all(),[
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email',
            'password' => 'sometimes|string|min:8',
        ], [
            'name.string' => 'نام باید به صورت متن باشد.',
            'name.max' => 'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'email.email' => 'فرمت ایمیل وارد شده صحیح نیست.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',

            'password.string' => 'رمز عبور باید به صورت متن باشد.',
            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد.',
        ]);
    }
}
