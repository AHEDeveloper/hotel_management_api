<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\AmenityRoom;
use App\Service\Admin\V1\AmenityRoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AmenityRoomAdmin extends Controller
{
    public function index()
    {
        $amenityRoom = AmenityRoom::query()->paginate(2);
        $items = collect($amenityRoom->items())->map(function ($item){
           return[
                $this->transformAR($item)
           ];
        });
        return ApiResponseClass::apiResponse(true,'AmenityRoom retrieved successfully',$amenityRoom,200);
    }

    public function show(AmenityRoom $amenityRoom)
    {
        return ApiResponseClass::apiResponse(true,'amenityRoom retrieved successfully',$this->transformAR($amenityRoom),200);
    }

    public function store(Request $request)
    {
        $validation = AmenityRoomService::validationStore($request);
        if ($validation->fails())
        {
            return ApiResponseClass::errorResponse('validation fail',$validation->errors(),422);
        }
        $amenityRoom = AmenityRoom::query()->create([
            'amenity_id' => $request->amenity_id,
            'room_id' => $request->room_id,
        ]);
        return ApiResponseClass::apiResponse(true,'amenityRoom created successfully',$this->transformAR($amenityRoom),201);
    }

    public function update(Request $request,AmenityRoom $amenityRoom)
    {
        $validation = AmenityRoomService::validationUpdate($request);

        if ($validation->fails())
        {
            return ApiResponseClass::errorResponse('validation fail',$validation->errors(),422);
        }
        $amenityRoom->update($request->all());
        return ApiResponseClass::apiResponse(true,'amenityRoom Updated successfully',$this->transformAR($amenityRoom),200);
    }

    public function destroy(AmenityRoom $amenityRoom)
    {
        return ApiResponseClass::apiResponse(true,'amenityRoom deleted successfully',$amenityRoom->delete(),200);
    }

    public function transformAR($item)
    {
        return[
            'id' => $item->id,
            'amenity' => [
                'name' => $item->amenity->name,
            ],
            'room' => [
                'room_number' => $item->room->room_number,
                'floor' => $item->room->floor,
                'status' => $item->room->status,
            ]
        ];
    }
}
