<?php

namespace App\Service\Admin\V1;

use Illuminate\Support\Facades\Validator;

class ReservationRoomService
{
    public static function validationUpdate($request)
    {
        return Validator::make($request->all(),[
            'reservation_id' => 'sometimes|exists:reservations,id',
            'room_id'        => 'sometimes|exists:rooms,id',
            'price'          => 'sometimes|numeric|min:0',
        ], [
            'reservation_id.exists' => 'رزرو انتخاب شده وجود ندارد.',

            'room_id.exists' => 'اتاق انتخاب شده وجود ندارد.',

            'price.numeric' => 'قیمت باید یک مقدار عددی باشد.',
            'price.min'     => 'قیمت نمی‌تواند منفی باشد.',
        ]);
    }
}
