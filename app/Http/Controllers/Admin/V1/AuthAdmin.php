<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthAdmin extends Controller
{

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|integer'
        ]);
        if ($validation->fails()) {
            return ApiResponseClass::errorResponse('validation fails', $validation->errors(), 422);
        }
        $credentials = ['email' => $request->email, 'password' => $request->password];
        $admin = Admin::query()->where('email', $credentials['email'])->first();
        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return ApiResponseClass::errorResponse(
                'unauthorized',
                'The provided credentials are invalid.',
                422
            );
        }
        $token = $admin->createToken('admin-token')->plainTextToken;
        return ApiResponseClass::apiResponse(true, 'admin login successfully', [
            $this->transformAdmin($admin,$token)
        ], 200);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return ApiResponseClass::apiResponse(true,'از حساب خود خارج شد'. auth()->user()->name,null,200);
    }

    public function transformAdmin($admin,$token)
    {
        return[
            'admin' => [
                'name' => $admin->name,
                'email' => $admin->email,
            ],
            'token' => $token,
            'role' => $admin->getRoleNames()
        ];
    }
}
