<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Service;
use App\Service\Admin\V1\ServicesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\This;

class ServiceAdmin extends Controller
{
    public function index()
    {
        $service = Service::query()->paginate(2);
        $items = collect($service->items())->map(function ($item){
           return[
                $this->transformService($item)
           ] ;
        });
        return ApiResponseClass::apiResponse(true,'service retrieved successfully',[
            'items' => $items,
            'meta' => [
                'total' => $service->total(),
                'current_page' => $service->currentPage(),
                'per_page' => $service->perPage(),
                'last_page' => $service->lastPage(),
            ]
        ],200);
    }

    public function show(Service $service)
    {
        $findService = Service::find($service->id);
        if (!$findService) {
            return ApiResponseClass::errorResponse('not_found', 'Service not found.', 404);
        }
        return ApiResponseClass::apiResponse(true,'service retrieved successfully',$this->transformService($service),200);
    }

    public function store(Request $request)
    {
        $validation = ServicesService::validationStore($request);
        if ($validation->fails()) {
            return ApiResponseClass::apiResponse(false, 'Validation failed.', $validation->errors(), 422);
        }
        $service = Service::query()->create([
           'name' => $request->name,
           'description' => $request->description,
           'price' => $request->price,
        ]);
        return ApiResponseClass::apiResponse(true,'service created successfully',$service,201);

    }

    public function update(Request $request,Service $service)
    {
        $findService = Service::find($service->id);
        if (!$findService) {
            return ApiResponseClass::errorResponse('not_found', 'Service not found.', 404);
        }
        $validation = ServicesService::validationUpdate($request);
        if ($validation->fails()) {
            return ApiResponseClass::apiResponse(false, 'Validation failed.', $validation->errors(), 422);
        }
        $service->update($request->all());
        return ApiResponseClass::apiResponse(true,'service updated successfully',$this->transformService($service),200);

    }

    public function destroy(Service $service)
    {
        $findService = Service::query()->find($service->id);
        if ($findService == null) {
            return ApiResponseClass::errorResponse('not_found', 'room is empty', 404);
        }
        return ApiResponseClass::apiResponse(true, 'Service deleted successfully', $service->delete(), 200);
    }

    public function transformService($item)

    {
        return[
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'price' => $item->price,
        ];
    }

}
