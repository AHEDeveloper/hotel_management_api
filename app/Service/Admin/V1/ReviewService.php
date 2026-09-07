<?php

namespace App\Service\Admin\V1;

use Illuminate\Support\Facades\Validator;

class ReviewService
{
    public static function validationUpdate($request)
    {
        return Validator::make($request->all(),[
            'reservation_id' => 'sometimes|exists:reservations,id',
            'rating'         => 'sometimes|integer|min:1|max:5',
            'comment'        => 'sometimes|nullable|string',
        ], [
            'reservation_id.exists' => 'رزرو انتخاب شده وجود ندارد.',

            'rating.integer' => 'امتیاز باید یک عدد صحیح باشد.',
            'rating.min'     => 'امتیاز باید حداقل ۱ باشد.',
            'rating.max'     => 'امتیاز نمی‌تواند بیشتر از ۵ باشد.',

            'comment.string' => 'نظر باید به صورت متنی باشد.',
        ]);
  }
}
