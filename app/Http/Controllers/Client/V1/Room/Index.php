<?php

namespace App\Http\Controllers\Client\V1\Room;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class Index extends Controller
{
    public function index(Request $request)
    {
        $query = Room::query()->with(['roomType','amenityRoom' => function ($q) {
            $q->with('amenity:id,name');
        }]);

        if ($request->filled('capacity')){
            $query->whereHas('roomType',function ($q) use ($request){
                $q->where('capacity',$request->capacity);
            });
        }

        if ($request->filled('status')){
            $query->where('status',$request->status);
        }
        if ($request->filled('floor')){
            $query->where('floor',$request->floor);
        }

        $per_page = (int) $request->get('per_page',10);
        if ($per_page > 100) {$per_page = 100;}
        if ($per_page < 1) {$per_page = 10;}
        $items = $query->paginate($per_page);

        $payloadItem = collect($items->items())->map(function ($item){
            return[
                $this->transformRoom($item)
            ];
        });

        if ($items->isEmpty()){
            return ApiResponseClass::errorResponse('empty','rooms is empty',422);
        }
        return ApiResponseClass::apiResponse(true,'room retrieved successfully',[
            'items' => $payloadItem,
            'meta' => [
                'total' => $items->total(),
                'current_page' => $items->currentPage(),
                'per_page' => $items->perPage(),
                'last_page' => $items->lastPage()
            ]
        ],200);
    }

    public function show(Room $room)
    {
        return ApiResponseClass::apiResponse(true,'room retrieved successfully',$this->transformRoom($room),200);
    }

    public function transformRoom($item)
    {
        return[
            'id' => $item->id,
            'room_number' => $item->room_number,
            'floor' => $item->floor,
            'status' => $item->status,
            'roomType' => [
                'id' => $item->roomType->id,
                'name' => $item->roomType->name,
                'capacity' => $item->roomType->capacity,
                'price_per_night' => $item->roomType->price_per_night,
                'description' => $item->roomType->description,
            ],
            'amenity' => $item->amenityRoom->map(function ($item) {
                return $item->amenity->name;
            }),
        ];
    }
}
