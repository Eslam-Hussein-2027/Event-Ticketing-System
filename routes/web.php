<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;



Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login.form');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');


Route::middleware('admin.web')->group(function () {

    Route::get('/admin/trips/create', [AdminDashboardController::class, 'createTrip'])
        ->name('admin.trips.create');

    Route::post('/admin/trips', [AdminDashboardController::class, 'storeTrip'])
        ->name('admin.trips.store');
});
