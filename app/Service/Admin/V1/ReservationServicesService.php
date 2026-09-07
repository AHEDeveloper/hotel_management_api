<?php

namespace App\Service\Admin\V1;

use Illuminate\Support\Facades\Validator;

class ReservationServicesService
{
  public static function validationUpdate($request)
  {
      return Validator::make($request->all(),[
          'reservation_id' => 'sometimes|exists:reservations,id',
          'service_id'     => 'sometimes|exists:services,id',
          'quantity'       => 'sometimes|integer|min:1',
          'price'          => 'sometimes|numeric|min:0',
      ], [
          'reservation_id.exists' => 'رزرو انتخاب شده وجود ندارد.',

          'service_id.exists' => 'سرویس انتخاب شده وجود ندارد.',

          'quantity.integer' => 'تعداد باید یک عدد صحیح باشد.',
          'quantity.min'     => 'تعداد باید حداقل ۱ باشد.',

          'price.numeric' => 'قیمت باید یک مقدار عددی باشد.',
          'price.min'     => 'قیمت نمی‌تواند منفی باشد.',
      ]);
  }
}
