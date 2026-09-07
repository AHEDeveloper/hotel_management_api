<?php

namespace App\Service\Admin\V1;

use Illuminate\Support\Facades\Validator;

class AmenityRoomService
{
    public static function validationStore($request)
    {
        return Validator::make($request->all(),[
            'room_id' => 'required|exists:rooms,id',
            'amenity_id' => 'required|exists:amenities,id',
        ], [
            'room_id.required' => 'انتخاب اتاق الزامی است.',
            'room_id.exists' => 'اتاق انتخاب‌شده معتبر نیست.',

            'amenity_id.required' => 'انتخاب امکانات رفاهی الزامی است.',
            'amenity_id.exists' => 'امکانات رفاهی انتخاب‌شده معتبر نیست.',
        ]);
    }

    public static function validationUpdate($request)
    {
        return Validator::make($request->all(),[
            'room_id'    => 'sometimes|exists:rooms,id',
            'amenity_id' => 'sometimes|exists:amenities,id',
        ], [
            'room_id.exists' => 'اتاق انتخاب شده وجود ندارد.',

            'amenity_id.exists' => 'امکانات انتخاب شده وجود ندارد.',
        ]);
    }


}
