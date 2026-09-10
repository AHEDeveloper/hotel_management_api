<?php

use App\Http\Controllers\Admin\V1\AdminControllerAdmin;
use App\Http\Controllers\Admin\V1\AmenityAdmin;
use App\Http\Controllers\Admin\V1\AmenityRoomAdmin;
use App\Http\Controllers\Admin\V1\PaymentAdmin;
use App\Http\Controllers\Admin\V1\ReservationAdmin;
use App\Http\Controllers\Admin\V1\ReservationRoomAdmin;
use App\Http\Controllers\Admin\V1\ReservationServiceAdmin;
use App\Http\Controllers\Admin\V1\ReviewAdmin;
use App\Http\Controllers\Admin\V1\RoomAdmin;
use App\Http\Controllers\Admin\V1\RoomImageAdmin;
use App\Http\Controllers\Admin\V1\RoomTypeAdmin;
use App\Http\Controllers\Admin\V1\ServiceAdmin;
use Illuminate\Support\Facades\Route;



// Admins
Route::middleware('permission:view admins')->get('/admin', [AdminControllerAdmin::class, 'index']);
Route::middleware('permission:create admins')->post('/admin', [AdminControllerAdmin::class, 'store']);
Route::middleware('permission:view admins')->get('/admin/{admin}', [AdminControllerAdmin::class, 'show']);
Route::middleware('permission:update admins')->put('/admin/{admin}', [AdminControllerAdmin::class, 'update']);
Route::middleware('permission:delete admins')->delete('/admin/{admin}', [AdminControllerAdmin::class, 'destroy']);


// Amenities
Route::middleware('permission:view amenities')->get('/amenity', [AmenityAdmin::class, 'index']);
Route::middleware('permission:create amenities')->post('/amenity', [AmenityAdmin::class, 'store']);
Route::middleware('permission:view amenities')->get('/amenity/{amenity}', [AmenityAdmin::class, 'show']);
Route::middleware('permission:update amenities')->put('/amenity/{amenity}', [AmenityAdmin::class, 'update']);
Route::middleware('permission:delete amenities')->delete('/amenity/{amenity}', [AmenityAdmin::class, 'destroy']);


// Amenity Rooms
Route::middleware('permission:view amenity rooms')->get('/amenity_room', [AmenityRoomAdmin::class, 'index']);
Route::middleware('permission:create amenity rooms')->post('/amenity_room', [AmenityRoomAdmin::class, 'store']);
Route::middleware('permission:view amenity rooms')->get('/amenity_room/{amenity_room}', [AmenityRoomAdmin::class, 'show']);
Route::middleware('permission:update amenity rooms')->put('/amenity_room/{amenity_room}', [AmenityRoomAdmin::class, 'update']);
Route::middleware('permission:delete amenity rooms')->delete('/amenity_room/{amenity_room}', [AmenityRoomAdmin::class, 'destroy']);


// Payments
Route::middleware('permission:view payments')->get('/payment', [PaymentAdmin::class, 'index']);
Route::middleware('permission:create payments')->post('/payment', [PaymentAdmin::class, 'store']);
Route::middleware('permission:view payments')->get('/payment/{payment}', [PaymentAdmin::class, 'show']);
Route::middleware('permission:update payments')->put('/payment/{payment}', [PaymentAdmin::class, 'update']);
Route::middleware('permission:delete payments')->delete('/payment/{payment}', [PaymentAdmin::class, 'destroy']);


// Reservations
Route::middleware('permission:view reservations')->get('/reservation', [ReservationAdmin::class, 'index']);
Route::middleware('permission:create reservations')->post('/reservation', [ReservationAdmin::class, 'store']);
Route::middleware('permission:view reservations')->get('/reservation/{reservation}', [ReservationAdmin::class, 'show']);
Route::middleware('permission:update reservations')->put('/reservation/{reservation}', [ReservationAdmin::class, 'update']);
Route::middleware('permission:delete reservations')->delete('/reservation/{reservation}', [ReservationAdmin::class, 'destroy']);


// Reservation Rooms
Route::middleware('permission:view reservation rooms')->get('/reservation_room', [ReservationRoomAdmin::class, 'index']);
Route::middleware('permission:create reservation rooms')->post('/reservation_room', [ReservationRoomAdmin::class, 'store']);
Route::middleware('permission:view reservation rooms')->get('/reservation_room/{reservation_room}', [ReservationRoomAdmin::class, 'show']);
Route::middleware('permission:update reservation rooms')->put('/reservation_room/{reservation_room}', [ReservationRoomAdmin::class, 'update']);
Route::middleware('permission:delete reservation rooms')->delete('/reservation_room/{reservation_room}', [ReservationRoomAdmin::class, 'destroy']);


// Reservation Services
Route::middleware('permission:view reservation services')->get('/reservation_service', [ReservationServiceAdmin::class, 'index']);
Route::middleware('permission:create reservation services')->post('/reservation_service', [ReservationServiceAdmin::class, 'store']);
Route::middleware('permission:view reservation services')->get('/reservation_service/{reservation_service}', [ReservationServiceAdmin::class, 'show']);
Route::middleware('permission:update reservation services')->put('/reservation_service/{reservation_service}', [ReservationServiceAdmin::class, 'update']);
Route::middleware('permission:delete reservation services')->delete('/reservation_service/{reservation_service}', [ReservationServiceAdmin::class, 'destroy']);


// Reviews
Route::middleware('permission:view reviews')->get('/review', [ReviewAdmin::class, 'index']);
Route::middleware('permission:create reviews')->post('/review', [ReviewAdmin::class, 'store']);
Route::middleware('permission:view reviews')->get('/review/{review}', [ReviewAdmin::class, 'show']);
Route::middleware('permission:update reviews')->put('/review/{review}', [ReviewAdmin::class, 'update']);
Route::middleware('permission:delete reviews')->delete('/review/{review}', [ReviewAdmin::class, 'destroy']);


// Rooms
Route::middleware('permission:view rooms')->get('/room', [RoomAdmin::class, 'index']);
Route::middleware('permission:create rooms')->post('/room', [RoomAdmin::class, 'store']);
Route::middleware('permission:view rooms')->get('/room/{room}', [RoomAdmin::class, 'show']);
Route::middleware('permission:update rooms')->put('/room/{room}', [RoomAdmin::class, 'update']);
Route::middleware('permission:delete rooms')->delete('/room/{room}', [RoomAdmin::class, 'destroy']);


// Room Gallery
Route::middleware('permission:view room images')
    ->get('/room/{room}/gallery', [RoomImageAdmin::class, 'index']);

Route::middleware('permission:create room images')
    ->post('/room/{room}/gallery', [RoomImageAdmin::class, 'store']);

Route::middleware('permission:delete room images')
    ->delete('/room/{room}/gallery/{image}', [RoomImageAdmin::class, 'delete']);


// Room Types
Route::middleware('permission:view room types')->get('/roomType', [RoomTypeAdmin::class, 'index']);
Route::middleware('permission:create room types')->post('/roomType', [RoomTypeAdmin::class, 'store']);
Route::middleware('permission:view room types')->get('/roomType/{roomType}', [RoomTypeAdmin::class, 'show']);
Route::middleware('permission:update room types')->put('/roomType/{roomType}', [RoomTypeAdmin::class, 'update']);
Route::middleware('permission:delete room types')->delete('/roomType/{roomType}', [RoomTypeAdmin::class, 'destroy']);


// Services
Route::middleware('permission:view services')->get('/service', [ServiceAdmin::class, 'index']);
Route::middleware('permission:create services')->post('/service', [ServiceAdmin::class, 'store']);
Route::middleware('permission:view services')->get('/service/{service}', [ServiceAdmin::class, 'show']);
Route::middleware('permission:update services')->put('/service/{service}', [ServiceAdmin::class, 'update']);
Route::middleware('permission:delete services')->delete('/service/{service}', [ServiceAdmin::class, 'destroy']);
