<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('auth/register',[AuthController::class,'register']);
Route::post('/auth/login',[AuthController::class,'login']);


Route::get('/trips', [TripController::class, 'index']);
Route::get('/trips/{trip}', [TripController::class, 'show']);

Route::get('/bookings', [BookingController::class, 'index']);
Route::post('/trips/{trip}/book', [BookingController::class, 'store']);
Route::delete('/bookings/{booking}', [BookingController::class, 'destroy']);


Route::middleware(['auth:sanctum','admin'])->group(function () {
    Route::post('/admin/trips', [\App\Http\Controllers\AdminTripController::class, 'store']);
    Route::patch('/admin/trips/{trip}', [\App\Http\Controllers\AdminTripController::class, 'update']);
});


