<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\DestinationController;

Route::post('register', RegisterController::class);
Route::post('login', LoginController::class);

Route::middleware('auth:sanctum')->group( function () {
    Route::resource('trips', TripController::class)
        ->except([
            'destroy', 'create', 'edit'
        ]);

    Route::resource('statuses', StatusController::class)
        ->only([
            'index',
        ]);
    
    Route::resource('destinations', DestinationController::class)
        ->only([
            'index',
        ]);
});


