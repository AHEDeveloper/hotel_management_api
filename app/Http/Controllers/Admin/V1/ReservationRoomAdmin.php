<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservationRoom;
use App\Service\Admin\V1\ReservationRoomService;
use Illuminate\Http\Request;

class ReservationRoomAdmin extends Controller
{
    public function index()
    {
        $RR = ReservationRoom::query()->paginate(2);
        $items = $RR->map(function ($item){
           return [
               $this->transformRR($item)
               ];
        });
        return ApiResponseClass::apiResponse(true,'get',[
            'items' => $items,
            'meta' => [
                'total' => $RR->total(),
                'current_page' => $RR->currentPage(),
                'per_page' => $RR->perPage(),
                'last_page' => $RR->lastPage(),
            ]
        ],200);
    }

    public function show(ReservationRoom $reservationRoom)
    {
        $RRFide = ReservationRoom::query()->find($reservationRoom->id);
        if (!$RRFide) {
            return ApiResponseClass::errorResponse('not_found', 'ReservationRoom not found.', 404);
        }

        return ApiResponseClass::apiResponse(true, 'ReservationRoom retrieved successfully.', $this->transformRR($reservationRoom), 200);
    }

    public function update(Request $request,ReservationRoom $reservationRoom)
    {
        $reservationFind = ReservationRoom::query()->find($reservationRoom->id);
        if (!$reservationFind) {
            return ApiResponseClass::errorResponse('not_found', 'ReservationRoom not found.', 404);
        }

        $validation = ReservationRoomService::validationUpdate($request);
        if ($validation->fails()) {
            return ApiResponseClass::apiResponse(false, 'validation is fails', $validation->errors(), 422);
        }

        $reservationRoom->update($request->all());
        return ApiResponseClass::apiResponse(true,'get',$this->transformRR($reservationRoom),200);
    }

    public function delete(ReservationRoom $reservationRoom)
    {
        if (!$reservationRoom) {
            return ApiResponseClass::errorResponse('not_found', 'ReservationRoom not found.', 404);
        }
        return ApiResponseClass::apiResponse(true,'ReservationRoom Deleted',$reservationRoom->delete(),200);

    }

    public function transformRR($item)
    {
        return[
            'id' => $item->id,
            'price' => $item->price,
            'reservation' => [
                'check_in' => $item->reservation->check_in,
                'check_out' => $item->reservation->check_out,
                'guests' => $item->reservation->guests,
                'status' => $item->reservation->status,
                ],
                'room' => [
                    'room_number' => $item->room->room_number,
                    'floor' => $item->room->floor
                ]
        ];
    }
}
