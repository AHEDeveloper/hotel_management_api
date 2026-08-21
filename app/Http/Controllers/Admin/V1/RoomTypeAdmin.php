<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\RoomType;
use \App\Service\Admin\V1\RoomTypeAdmin as Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomTypeAdmin extends Controller
{

    public function index()
    {
        $roomType = RoomType::query()->paginate(2);
        return ApiResponseClass::apiResponse(true,'get RoomType successfully',$roomType,200);
    }

    public function show($id)
    {
        $roomType = RoomType::find($id);
        if ($roomType == null)
        {
            return ApiResponseClass::errorResponse('not_found','roomType is empty',404);
        }
        return ApiResponseClass::apiResponse(true,'get RoomType successfully',$roomType,200);
    }

    public function store(Request $request)
    {
        $validation = Service::validation($request);
        $this->errorFail($validation);
        $roomType = RoomType::query()->create([
            'id' => $request->id,
            'name' => $request->name,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'price_per_night' => $request->price_per_night,
        ]);
        return ApiResponseClass::apiResponse(true,'roomType created',$roomType,201);
    }

    public function update(RoomType $roomType,Request $request)
    {
        $validation = Service::validation($request);
        $this->errorFail($validation);
        $roomType->query()->update($request->all());
        return ApiResponseClass::apiResponse(true,'roomType created',$roomType,201);
    }



    public function errorFail($validation)
    {
        if ($validation->fails())
        {
            return ApiResponseClass::apiResponse(false,'validation is fails',$validation->errors(),422);
        }
    }
    public function destroy($id)
    {
        $roomType = RoomType::find($id);
        if ($roomType == null)
        {
            return ApiResponseClass::errorResponse('not_found','roomType is empty',404);
        }
        return ApiResponseClass::apiResponse(true,'roomType is deleted',$roomType->delete(),200);
    }

}
