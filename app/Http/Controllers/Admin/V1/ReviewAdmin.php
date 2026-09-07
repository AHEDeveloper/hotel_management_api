<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Service\Admin\V1\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewAdmin extends Controller
{
    public function index()
    {
        $reviews = Review::query()->paginate();
        $items = collect($reviews->items())->map(function ($item){
           return[
                $this->transformReview($item)
           ] ;
        });
        return ApiResponseClass::apiResponse(true,'review retrieved successfully',[
            'items' => $items,
            'meta' => [
                'total' => $reviews->total(),
                'current_page' => $reviews->currentPage(),
                'per_page' => $reviews->perPage(),
                'last_page' => $reviews->lastPage(),
            ]
        ],200);
    }

    public function show(Review $review)
    {
        $findReview = Review::find($review->id);
        if (!$findReview) {
            return ApiResponseClass::errorResponse('not_found', 'review not found.', 404);
        }
        return ApiResponseClass::apiResponse(true,'review retrieved successfully',$this->transformReview($review),200);
    }

    public function update(Request $request,Review $review)
    {
        $findReview = Review::query()->find($review->id);
        if (!$findReview){
            return ApiResponseClass::errorResponse('not_found','Review Not Found',422);
        }
        $validation = ReviewService::validationUpdate($request);
        if ($validation->fails()) {
            return ApiResponseClass::errorResponse('validation fails' ,$validation->errors(), 422);
        }
        $review->update($request->all());
        return ApiResponseClass::apiResponse(true,'review updated successfully',$this->transformReview($review),200);
    }

    public function destroy(Review $review)
    {
        $findReview = Review::query()->find($review->id);
        if (!$findReview){
            return ApiResponseClass::errorResponse('not_found','Review Not Found',422);
        }
        return ApiResponseClass::apiResponse(true,'review deleted successfully',$review->delete(),200);
    }

    public function transformReview($item)
    {
        return[
            'id' => $item->id,
            'rating' => $item->rating,
            'comment' => $item->comment,
            'reservation' => [
                'check_in' => $item->reservation->check_in,
                'check_out' => $item->reservation->check_out,
                'status' => $item->reservation->status,
            ],
        ];
    }
}
