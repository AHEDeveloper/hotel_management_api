<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Service\Admin\V1\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationAdmin extends Controller
{
    public function index()
    {
        $reservations = Reservation::query()->get();
        $items = $reservations->map(function ($item){
            return [
                    $this->transformReservation($item)
              ];
        });
        return ApiResponseClass::apiResponse(true,'Reservation retrieved successfully',$items,200);
    }

    public function show($id)
    {
        $reservation = Reservation::query()->find($id);
        if (!$reservation) {
            return ApiResponseClass::errorResponse('not_found', 'Reservation not found.', 404);
        }

        return ApiResponseClass::apiResponse(true,'Reservation retrieved successfully',$this->transformReservation($reservation),200);

    }

    public function update(Request $request,Reservation $reservation)
    {
        $reservationFind = Reservation::query()->find($reservation->id);
        if (!$reservationFind) {
            return ApiResponseClass::errorResponse('not_found', 'Reservation not found.', 404);
        }

        $validation = ReservationService::validationUpdate($request);
        if ($validation->fails()) {
            return ApiResponseClass::apiResponse(false, 'validation is fails', $validation->errors(), 422);
        }
        $reservation->update($request->only([
                    'check_in',
            'check_out',
            'guests',
            'total_price',
            'status',
            'user_id',
        ]));
        return ApiResponseClass::apiResponse(true,'Reservation updated successfully',$this->transformReservation($reservation),200);
    }

    public function destroy(Reservation $reservation)
    {
        $reservationFind = Reservation::query()->find($reservation->id);
        if (!$reservationFind) {
            return ApiResponseClass::errorResponse('not_found', 'Reservation not found.', 404);
        }
        return ApiResponseClass::apiResponse(true,'Reservation deleted successfully',$reservation->delete(),200);
    }

    public function transformReservation($item)
    {
        return [
            'id' => $item->id,
            'check_in' => $item->check_in,
            'check_out' => $item->check_out,
            'guests' => $item->guests,
            'total_price' => $item->total_price,
            'status' => $item->status,
            'user' => [
                'name' => $item->user->name,
                'email' => $item->user->email
            ],
        ];
    }
}
