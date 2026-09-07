<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\ReservationService;
use App\Service\Admin\V1\ReservationServicesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationServiceAdmin extends Controller
{
    public function index()
    {
        $reservationService = ReservationService::query()->paginate(2);
        $items = collect($reservationService->items())->map(function ($item) {
            return [
              $this->transformRS($item)
            ];
        });
        return ApiResponseClass::apiResponse(true, 'ReservationService retrieved successfully', [
            'items' => $items,
            'meta' => [
                'total' => $reservationService->total(),
                'current_page' => $reservationService->currentPage(),
                'per_page' => $reservationService->perPage(),
                'last_page' => $reservationService->lastPage(),
            ]
        ], 200);
    }

    public function show(ReservationService $reservationService)
    {
        $findRS = ReservationService::query()->find($reservationService->id);
        if (!$findRS)
        {
            return ApiResponseClass::errorResponse('not_found','ReservationService not Found',422);
        }
        return ApiResponseClass::apiResponse(true,'ReservationService retrieved successfully',$this->transformRS($reservationService),200);
    }

    public function update(Request $request,ReservationService $reservationService)
    {
        $findRS = ReservationService::query()->find($reservationService->id);
        if (!$findRS)
        {
            return ApiResponseClass::errorResponse('not_found','ReservationService not Found',422);
        }

        $validator = ReservationServicesService::validationUpdate($request);
        if ($validator->fails())
        {
            return ApiResponseClass::errorResponse('validation is fails',$validator->errors(),422);
        }

        $reservationService->update($request->only([

            'quantity',
            'price',
            'reservation_id',
            'service_id',
        ]));
        return ApiResponseClass::apiResponse(true,'ReservationService Updated successfully',$this->transformRS($reservationService),200);

    }

    public function destroy(ReservationService $reservationService)
    {
        $findRS = ReservationService::query()->find($reservationService->id);
        if (!$findRS)
        {
            return ApiResponseClass::errorResponse('not_found','ReservationService not Found',422);
        }
        return ApiResponseClass::apiResponse(true,
            'ReservationService Deleted successfully',
            $reservationService->delete(),
            200);

    }


    public function transformRS($item)
    {
        return[
            'id' => $item->id,
            'quantity' => $item->quantity,
            'price' => $item->price,
            'reservation' => [
                'check_in' => $item->reservation->check_in,
                'check_out' => $item->reservation->check_out,
                'status' => $item->reservation->status,
            ],
            'service' => [
                'name' => $item->service->name,
                'price' => $item->service->price,
            ]
        ];
    }
}
