<?php

namespace App\Http\Controllers\Client\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Jobs\Admin\V1\ExpireUnpaidReservationJob;
use App\Models\Reservation;
use App\Models\ReservationRoom;
use App\Models\Room;
use App\Service\Client\V1\ReservationServiceClient;
use App\Service\Ghasedak\smsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReservationControllerClient extends Controller
{

    public function index()
    {
        $reservations = Reservation::query()
            ->where('user_id', Auth::id())
            ->with('reservationRoom.room')
            ->get();

        $items = $reservations->map(function ($reservation) {
            return [
                'id' => $reservation->id,
                'check_in' => $reservation->check_in,
                'check_out' => $reservation->check_out,
                'total_price' => $reservation->total_price,
                'status' => $reservation->status,

                'reservationRoom' => $reservation->reservationRoom->map(function ($reservationRoom) {
                    return [
                        'room_id' => $reservationRoom->room_id,
                        'price' => $reservationRoom->price,
                        'room' => [
                            'id' => $reservationRoom->room->id,
                            'room_number' => $reservationRoom->room->room_number,
                            'price' => $reservationRoom->room->roomType->price_per_night,
                            'type' => $reservationRoom->room->roomType->name,
                        ],
                    ];
                }),
            ];
        });
        return ApiResponseClass::apiResponse(true,'reservation retrieved successfully',$items,200);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $exist = $this->hasActiveReservation($user->id);
        $reserved = $this->isRoomReserved($request);

        $room = Room::query()->where('id',$request->room_id)->first();
       if (!$reserved){

           if (!$exist)
           {
               $validator = ReservationServiceClient::validation($request);
               if ($validator->fails())
               {
                   return ApiResponseClass::errorResponse('validation fail',$validator->errors(),422);
               }

               $checkIn = Carbon::parse($request->check_in);
               $checkOut = Carbon::parse($request->check_out);
               $days = intval($checkIn->diffInDays($checkOut));
               $totalPrice = $days * $room->roomType->price_per_night;

               $reservation = Reservation::query()->create([
                   'user_id' => $user->id,
                   'check_in' => $request->check_in,
                   'check_out' => $request->check_out,
                   'guests' => $request->guests,
                   'total_price' => $totalPrice,
                   'status' => $request->status,
               ]);
               ReservationRoom::query()->create([
                   'reservation_id' => $reservation->id,
                   'room_id' => $room->id,
                   'price' => $room->roomType->price_per_night
               ]);
               $room->update(['status' => 'maintenance']);

               return ApiResponseClass::apiResponse(true,'created Reservation successfully',$this->transformReservation($reservation,$room),201);
           }
           else{
               $reservation = $this->getUserReservation(Auth::id());
               ReservationRoom::query()->create([
                   'reservation_id' => $reservation->id,
                   'room_id' =>$room->id,
                   'price' => $room->roomType->price_per_night
               ]);
               $sumPrice = $reservation->total_price + $room->roomType->price_per_night;
               $reservation->update([
                   'total_price' => $sumPrice
               ]);
               $room->update(['status' => 'maintenance']);
               ExpireUnpaidReservationJob::dispatch($reservation,$user->phone)->delay(now()->addSecond(1));
               return ApiResponseClass::apiResponse(true,'update reservation successfully',$this->transformReservation($reservation,$room),200);
           }
       }else
       {
           return ApiResponseClass::errorResponse('room full','room is full',422);
       }

    }

    public function hasActiveReservation($userId)
    {
        return Reservation::query()
            ->where('user_id',$userId)
            ->where('status','=','pending')
            ->where('status','=','confirmed')
            ->exists();
    }

    public function isRoomReserved($request)
    {
        return ReservationRoom::query()
            ->where('room_id', $request->room_id)
            ->whereHas('reservation', function ($query) use ($request) {
                $query
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->where('check_in', '<', $request->check_out)
                    ->where('check_out', '>', $request->check_in);
            })
            ->exists();
    }

    public function getUserReservation($userId)
    {
        return Reservation::query()->where('user_id',$userId)->first();
    }

    public function deleteReservation(Reservation $reservation)
    {
        return ApiResponseClass::apiResponse(true,'deleted Reservation successfully',$reservation->delete(),200);
    }

    public function deleteReservationRoom(ReservationRoom $reservationRoom)
    {
        $reservation = $this->getUserReservation(Auth::id());
        $price = $reservation->total_price - $reservationRoom->price;
        $reservation->update(['total_price' => $price]);
        $reservationRoom->room->update(['status' => 'available']);

        return ApiResponseClass::apiResponse(true,'deleted ReservationRoom successfully',$reservationRoom->delete(),200);
    }

    public function transformReservation($reservation,$room)
    {
        return[
            'room_number' => $room->room_number,
            'room-type' => $room->roomType->name,
            'check_in' => $reservation->check_in,
            'check_out' => $reservation->check_out,
            'total_price' => $reservation->total_price,
            'status' => $reservation->status,
        ];
    }
}
