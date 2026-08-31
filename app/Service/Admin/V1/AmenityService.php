<?php

namespace App\Service\Admin\V1;

use Illuminate\Support\Facades\Validator;

class AmenityService
{
    public static function validationStore($request)
    {
       return Validator::make($request->all(),[
            'name' => 'required|max:150|min:3|unique:amenities,name'
       ],[
           'name.required' => 'لطفا نوع امکان رفاهی را پر کنید',
           'name.max' => 'لطفا بیشتر از 150 کارکتر استفاده نکنید',
           'name.min' => 'لطفا کمتر از 3 کارکتر استفاده نکنید',
           'name.unique' => 'این نوع امکان رفاهی قبلا استفاده شده',
       ]);
    }
    public static function validationUpdate($request)
    {
       return Validator::make($request->all(),[
            'name' => 'max:150|min:3|unique:amenities,name'
       ],[
           'name.max' => 'لطفا بیشتر از 150 کارکتر استفاده نکنید',
           'name.min' => 'لطفا کمتر از 3 کارکتر استفاده نکنید',
           'name.unique' => 'این نوع امکان رفاهی قبلا استفاده شده',
       ]);
    }
}
