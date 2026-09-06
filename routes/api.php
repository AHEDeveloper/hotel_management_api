<?php

use App\Http\Controllers\Admin\V1\AmenityAdmin;
use App\Http\Controllers\Admin\V1\PaymentAdmin;
use App\Http\Controllers\Admin\V1\ReservationAdmin;
use App\Http\Controllers\Admin\V1\ReservationRoomAdmin;
use App\Http\Controllers\Admin\V1\RoomAdmin;
use App\Http\Controllers\Admin\V1\RoomImageAdmin;
use App\Http\Controllers\Admin\V1\RoomTypeAdmin;
use App\Http\Controllers\Admin\V1\ServiceAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/admin')->group(function (){
    Route::apiResource('/roomType', RoomTypeAdmin::class);
    Route::apiResource('/room', RoomAdmin::class);

    Route::prefix('room/{room}/gallery')->controller(RoomImageAdmin::class)->group(function (){
        Route::get('/','index');
        Route::post('/','store');
        Route::delete('/{image}','delete');
    });

    Route::post('/roomImage', [RoomImageAdmin::class,'store']);
    Route::apiResource('/amenity', AmenityAdmin::class);
    Route::apiResource('/reservation', ReservationAdmin::class);
    Route::apiResource('/reservation_room', ReservationRoomAdmin::class);
    Route::apiResource('/payment', PaymentAdmin::class);
    Route::apiResource('/service', ServiceAdmin::class);
});

