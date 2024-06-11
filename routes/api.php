<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login',[ApiController::class, 'login']);

Route::post('/register',[ApiController::class, 'reginter']);

Route::post('/logout',[ApiController::class, 'logout'])->middleware('auth_sanctum');