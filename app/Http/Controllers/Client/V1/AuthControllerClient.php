<?php

namespace App\Http\Controllers\Client\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthControllerClient extends Controller
{
    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ], [
            'name.required' => 'وارد کردن نام الزامی است.',
            'name.string' => 'نام باید به صورت متن باشد.',
            'name.min' => 'نام باید حداقل ۳ کاراکتر باشد.',
            'name.max' => 'نام نمی‌تواند بیشتر از ۱۰۰ کاراکتر باشد.',

            'email.required' => 'وارد کردن ایمیل الزامی است.',
            'email.email' => 'لطفاً یک ایمیل معتبر وارد کنید.',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است.',

            'password.required' => 'وارد کردن رمز عبور الزامی است.',
            'password.string' => 'رمز عبور باید به صورت متن باشد.',
        ]);
        if ($validation->fails())
        {
            return ApiResponseClass::errorResponse('validation fails',$validation->errors(),422);
        }
        $user = User::query()->create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => bcrypt($request->password),
        ]);
        $token = $user->createToken('client-token')->plainTextToken;
        $user['token'] = $token;
        return ApiResponseClass::apiResponse(true,'user created successfully',$user,201);

    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string',
        ],[
            'email.email' => 'لطفاً یک ایمیل معتبر وارد کنید.',

            'password.string' => 'رمز عبور باید به صورت متن باشد.',
        ]);

        if($validation->fails()){
            return ApiResponseClass::errorResponse('validation fail',$validation->errors(),422);
        }
        $user = User::query()->where('email',$request->email)->first();
        $token = $user->createToken('client-token')->plainTextToken;
        $user['token'] = $token;
        return ApiResponseClass::apiResponse(true,'login user',$user,200);
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return ApiResponseClass::apiResponse(true,'user is logout',null,200);
    }
}
