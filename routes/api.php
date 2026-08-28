<?php

use App\Http\Controllers\Admin\V1\RoomAdmin;
use App\Http\Controllers\Admin\V1\RoomTypeAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/admin')->group(function (){
    Route::apiResource('/roomType', RoomTypeAdmin::class);
    Route::apiResource('/room', RoomAdmin::class);
});

