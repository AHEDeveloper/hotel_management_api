<?php

namespace App\Http\Controllers\Admin\V1;

use App\Classes\ApiResponseClass;
use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;


class RoomImageAdmin extends Controller
{
    public function index(Room $room)
    {
        $image = RoomImage::query()->where('room_id',$room->id)->get();

        $items = $image->map(function ($item){
        return $this->transFormRoomImage($item);
        });

        return ApiResponseClass::apiResponse('true','get',$items,200);
    }
    public function store(Request $request,Room $room)
    {
        $photos = $request->file('photos');
        $request['photos'] = $photos;
        $validator = Validator::make($request->all(), [
            'photos' => 'required|array',
            'photos.*' => 'image|mimes:png,jpg,webp,jpeg,svg,gif|max:2048'
        ]);
        if ($validator->fails())
        {
            return ApiResponseClass::errorResponse('validation fails',$validator->errors(),422);
        }
        foreach ($photos as $photo){
            $this->resizeImage($photo,$room->id,100,100,'small');
            $this->resizeImage($photo,$room->id,400,400,'medium');
            $this->resizeImage($photo,$room->id,800,800,'large');
        }

        foreach ($photos as $photo)
        {
            $path = pathinfo($photo->hashName(), PATHINFO_FILENAME) . '.webp';
            $images = RoomImage::query()->create([
                'path' => $path ,
                'is_active' => $request->is_active ,
                'room_id' => $room->id
            ]);
        }

        return ApiResponseClass::apiResponse(true,'ok',$images,201);
    }

    public function transFormRoomImage($item)
    {
        return [
            'id' => $item->id,
            'path' => $item->path,
            'is_active' => $item->is_active,
            'room' => [
                'room_number' => $item->room->room_number,
                'floor' => $item->room->floor,
                'status' => $item->room->status,
            ]
        ];
    }

    public function resizeImage($photo,$roomId,$width,$height,$folder)
    {
        $image = new ImageManager(new Driver());

        $filename = pathinfo($photo->hashName(), PATHINFO_FILENAME) . '.webp';

        $path = 'rooms/' . $roomId . '/' . $folder . '/' . $filename;

        $webp = $image->read($photo->getRealPath())
            ->scale($width, $height)
            ->toWebp();

        Storage::disk('public')->put($path, (string) $webp);
    }
    public function delete(Room $room,RoomImage $image)
    {
        $image->delete();
        $pathSmall = 'rooms/'.$room->id.'/small/'.$image->path;
        $pathMedium = 'rooms/'.$room->id.'/medium/'.$image->path;
        $pathLarge = 'rooms/'.$room->id.'/large/'.$image->path;
        Storage::disk('public')->delete($pathSmall);
        Storage::disk('public')->delete($pathMedium);
        Storage::disk('public')->delete($pathLarge);
        return ApiResponseClass::apiResponse(true,'Image deleted successfully.',null,200);
    }
}
