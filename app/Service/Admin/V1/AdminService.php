<?php

namespace App\Service\Admin\V1;

use Illuminate\Support\Facades\Validator;

class AdminService
{
    public static function validationStore($request)
    {
        $role = ['room admin','reservation admin','service admin'];
        return Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string',
            'role' => 'required', 'string', 'in:' . implode(',', $role),
        ], [
            'name.required' => 'وارد کردن نام الزامی است.',
            'name.string' => 'نام باید به صورت متن باشد.',
            'name.max' => 'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'email.required' => 'وارد کردن ایمیل الزامی است.',
            'email.email' => 'فرمت ایمیل وارد شده صحیح نیست.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',

            'password.required' => 'وارد کردن رمز عبور الزامی است.',
            'password.string' => 'رمز عبور باید به صورت متن باشد.',

            'role.required' => 'وارد کردن نقش الزامی است.',
            'role.string'   => 'نقش باید به صورت متن باشد.',
            'role.in'       => 'این نقش مجاز نیست. فقط room admin، reservation admin یا service admin قابل انتخاب است.',
        ]);
    }

    public static function validationUpdate($request)
    {
        $role = ['room admin','reservation admin','service admin'];
       return Validator::make($request->all(),[
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email',
            'password' => 'sometimes|string',
           'role' => 'string', 'in:' . implode(',', $role),

        ], [
            'name.string' => 'نام باید به صورت متن باشد.',
            'name.max' => 'نام نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',

            'email.email' => 'فرمت ایمیل وارد شده صحیح نیست.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',

            'password.string' => 'رمز عبور باید به صورت متن باشد.',

           'role.string'   => 'نقش باید به صورت متن باشد.',
           'role.in'       => 'این نقش مجاز نیست. فقط room admin، reservation admin یا service admin قابل انتخاب است.',
        ]);
    }
}
