<?php

use App\Http\Controllers\Client\V1\AuthControllerClient;
use App\Http\Controllers\Client\V1\HomePage as HomePage;
use App\Http\Controllers\Client\V1\RoomControllerClient as RoomPage;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/admin')->group(function () {
    require __DIR__ . '/admin_V1.php';
});

Route::prefix('v1')->group(function (){
    Route::post('/register', [AuthControllerClient::class,'register']);
    Route::post('/login', [AuthControllerClient::class,'login']);

    Route::middleware('auth:sanctum')->group(function (){
        Route::post('/logout', [AuthControllerClient::class,'logout']);
        Route::get('/hotel',[HomePage::class,'index']);
        Route::get('/rooms',[RoomPage::class,'index']);
        Route::get('/rooms/{room}',[RoomPage::class,'show']);

    });


});

