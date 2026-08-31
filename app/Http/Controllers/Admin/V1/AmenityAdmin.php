<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Service\Admin\V1\AmenityService;


class AmenityAdmin extends Controller
{

    public function index()
    {
        $amenity = Amenity::query()->get();
        return ApiResponseClass::apiResponse(true,'amenity retrieved successfully',$amenity,200);
    }

    public function show($id)
    {
       $amenity = Amenity::find($id);
       if (!$amenity){
           return ApiResponseClass::errorResponse('not_found', 'amenity not found.', 404);
       }
        return ApiResponseClass::apiResponse(true, 'amenity retrieved successfully.', $amenity, 200);

    }

    public function store(Request $request)
    {
        $validation = AmenityService::validationStore($request);

        if ($validation->fails()) {
            return ApiResponseClass::apiResponse(false, 'Validation failed.', $validation->errors(), 422);
        }

        $amenity = Amenity::query()->create([
         'name' => $request->name
        ]);

        return ApiResponseClass::apiResponse(true, 'Amenity created successfully.', $amenity, 201);
    }

    public function update(Amenity $amenity,Request $request)
    {
        $validation = AmenityService::validationUpdate($request);
        if ($validation->fails()) {
            return ApiResponseClass::apiResponse(false, 'Validation failed.', $validation->errors(), 422);
        }
        $amenity->update($request->only([
            'name'
        ]));

        return ApiResponseClass::apiResponse(true, 'Amenity Updated successfully.', $amenity, 201);
    }

    public function destroy($id)
    {
        $amenity = Amenity::find($id);
        if (!$amenity){
            return ApiResponseClass::errorResponse('not_found', 'amenity not found.', 404);
        }
        return ApiResponseClass::apiResponse(true,$amenity->name.'is deleted',$amenity->delete(),200);
    }
}
