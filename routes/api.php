<?php

use App\Http\Controllers\Client\V1\HomePage\Index as HomePage;
use App\Http\Controllers\Client\V1\Room\Index as RoomPage;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/admin')->group(function () {
    require __DIR__ . '/admin_V1.php';
});

Route::prefix('v1')->group(function (){
    Route::get('/hotel',[HomePage::class,'index']);
    Route::get('/rooms',[RoomPage::class,'index']);
    Route::get('/rooms/{room}',[RoomPage::class,'show']);
});





