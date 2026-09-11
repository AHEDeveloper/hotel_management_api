<?php

use App\Http\Controllers\Admin\V1\AdminControllerAdmin;
use App\Http\Controllers\Admin\V1\AmenityAdmin;
use App\Http\Controllers\Admin\V1\AmenityRoomAdmin;
use App\Http\Controllers\Admin\V1\AuthAdmin;
use App\Http\Controllers\Admin\V1\PaymentAdmin;
use App\Http\Controllers\Admin\V1\ReservationAdmin;
use App\Http\Controllers\Admin\V1\ReservationRoomAdmin;
use App\Http\Controllers\Admin\V1\ReservationServiceAdmin;
use App\Http\Controllers\Admin\V1\ReviewAdmin;
use App\Http\Controllers\Admin\V1\RoomAdmin;
use App\Http\Controllers\Admin\V1\RoomImageAdmin;
use App\Http\Controllers\Admin\V1\RoomTypeAdmin;
use App\Http\Controllers\Admin\V1\ServiceAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login',[AuthAdmin::class,'login'])->name('login');
Route::middleware('auth:sanctum')->group(function (){
    Route::post('/logout',[AuthAdmin::class,'logout'])->name('logout');
        Route::apiResource('/roomType', RoomTypeAdmin::class);
        Route::apiResource('/room', RoomAdmin::class);
        Route::prefix('room/{room}/gallery')->controller(RoomImageAdmin::class)->group(function (){
            Route::get('/','index');
            Route::post('/','store');
            Route::delete('/{image}','delete');
        });
    Route::apiResource('/amenity', AmenityAdmin::class);
    Route::apiResource('/reservation', ReservationAdmin::class);
    Route::apiResource('/reservation_room', ReservationRoomAdmin::class);
    Route::apiResource('/payment', PaymentAdmin::class);
    Route::apiResource('/service', ServiceAdmin::class);
    Route::apiResource('/reservation_service', ReservationServiceAdmin::class);
    Route::apiResource('/review', ReviewAdmin::class);
    Route::apiResource('/amenity_room', AmenityRoomAdmin::class);
    Route::apiResource('/admin', AdminControllerAdmin::class);
    require __DIR__ . '/admin_Permission.php';
});


