<?php

use App\Http\Controllers\Admin\V1\RoomTypeAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function (){
    Route::apiResource('/roomType', RoomTypeAdmin::class);
});

