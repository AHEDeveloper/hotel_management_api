<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use App\Service\Admin\V1\RoomService as Service;
use Illuminate\Http\Request;

class RoomAdmin extends Controller
{
    public function index()
    {
        $rooms = Room::query()->paginate(2);
        $items = collect($rooms->items())->map(function ($item){
           return [
              $this->transformRoom($item)
           ];
        });
        return ApiResponseClass::apiResponse(true, 'Room retrieved successfully.',[
            'items' => $items,
            'meta' => [
                'total' => $rooms->total(),
                'current_page' => $rooms->currentPage(),
                'per_page' => $rooms->perPage(),
                'last_page' => $rooms->lastPage(),
            ]
        ], 200);
    }

    public function show(Room $room)
    {
        $room = Room::find($room->id);
        if (!$room) {
            return ApiResponseClass::errorResponse('not_found', 'Room not found.', 404);
        }

        return ApiResponseClass::apiResponse(true, 'Room retrieved successfully.', $this->transformRoom($room), 200);
    }

    public function transformRoom($item)
    {
        return [
            'id' => $item->id,
            'room_number' => $item->room_number,
            'floor' => $item->floor,
            'roomType' => [
                'name' => $item->roomType->name,
                'capacity' => $item->roomType->capacity,
                'price_per_night' => $item->roomType->price_per_night,
            ]
        ];
    }

    public function store(Request $request)
    {
        $validation = Service::validationStore($request);

        if ($validation->fails()) {
            return ApiResponseClass::apiResponse(false, 'Validation failed.', $validation->errors(), 422);
        }

        $room = Room::query()->create([
            'room_number' => $request->room_number,
            'floor' => $request->floor,
            'status' => $request->status,
            'room_type_id' => $request->room_type_id,
        ]);

        return ApiResponseClass::apiResponse(true, 'Room created successfully.', $this->transformRoom($room), 201);
    }

    public function update(Room $room, Request $request)
    {
        $validation = Service::validationSUpdate($request);
        if ($validation->fails()) {
            return ApiResponseClass::apiResponse(false, 'validation is fails', $validation->errors(), 422);
        }
        $room->update($request->only([
            'room_number' ,
            'floor',
            'status' ,
            'room_type_id'
        ]));
        return ApiResponseClass::apiResponse(true, 'Room updated successfully', $this->transformRoom($room), 201);
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        if ($room == null) {
            return ApiResponseClass::errorResponse('not_found', 'room is empty', 404);
        }
        return ApiResponseClass::apiResponse(true, 'Room deleted successfully', $room->delete(), 200);
    }


}
