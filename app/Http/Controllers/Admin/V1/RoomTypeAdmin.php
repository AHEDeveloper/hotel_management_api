<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\RoomType;
use \App\Service\Admin\V1\RoomTypeService as Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomTypeAdmin extends Controller
{

    public function index()
    {
        $roomTypes = RoomType::query()->paginate(2);

        return ApiResponseClass::apiResponse(true, 'Room types retrieved successfully.', $roomTypes, 200);
    }

    public function show($id)
    {
        $roomType = RoomType::find($id);

        if (!$roomType) {
            return ApiResponseClass::errorResponse('not_found', 'Room type not found.', 404);
        }

        return ApiResponseClass::apiResponse(true, 'Room type retrieved successfully.', $roomType, 200);
    }

    public function store(Request $request)
    {
        $validation = Service::validationStore($request);

        if ($validation->fails()) {
            return ApiResponseClass::apiResponse(false, 'Validation failed.', $validation->errors(), 422);
        }

        $roomType = RoomType::query()->create([
            'name' => $request->name,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'price_per_night' => $request->price_per_night,
        ]);

        return ApiResponseClass::apiResponse(true, 'Room type created successfully.', $roomType, 201);
    }

    public function update(RoomType $roomType, Request $request)
    {
        $validation = Service::validationUpdate($request);
        if ($validation->fails()) {
            return ApiResponseClass::apiResponse(false, 'validation is fails', $validation->errors(), 422);
        }
        $roomType->update($request->only([
            'name',
            'capacity',
            'price_per_night'
        ]));
        return ApiResponseClass::apiResponse(true, 'Room type updated successfully', $roomType, 201);
    }

    public function destroy($id)
    {
        $roomType = RoomType::find($id);
        if ($roomType == null) {
            return ApiResponseClass::errorResponse('not_found', 'roomType is empty', 404);
        }
        return ApiResponseClass::apiResponse(true, 'Room type deleted successfully', $roomType->delete(), 200);
    }

}
