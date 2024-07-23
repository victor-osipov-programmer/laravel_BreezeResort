<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::post('/room', [RoomController::class, 'store']);
Route::get('/rooms', [RoomController::class, 'index']);
Route::delete('/room/{room}', [RoomController::class, 'destroy']);
Route::get('/usersinroom', [RoomController::class, 'getUsersInRooms']);

Route::post('/signup', [UserController::class, 'createAdministrator']);
Route::post('/register', [UserController::class, 'store']);
Route::get('/room/{room}/userdata/{user}', [UserController::class, 'changeRoom']);
Route::patch('/userdata/{user}', [UserController::class, 'update']);
Route::delete('/userdata/{user}', [UserController::class, 'destroy']);

Route::post('/hotel', [HotelController::class, 'store']);
Route::get('/hotels', [HotelController::class, 'index']);
Route::delete('/hotel/{hotel}', [HotelController::class, 'destroy']);
Route::get('/hotel/{hotel}/room/{room}', [HotelController::class, 'addRoomInHotel']);
Route::get('/roomsinhotels', [HotelController::class, 'getRoomsInHotels']);