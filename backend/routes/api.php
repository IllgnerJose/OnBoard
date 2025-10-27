<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TripController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\DestinationController;
use App\Http\Resources\UserResource;
use App\Http\Controllers\NotificationController;

Route::post('register', RegisterController::class)->name('register');
Route::post('login', LoginController::class)->name('login');

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);

    Route::get('user', function (Request $request) {
            return new UserResource($request->user());
        });

    Route::resource('trips', TripController::class)
        ->except([
            'destroy', 'create', 'edit', 'update'
        ]);

    Route::put("trips/approve/{trip}", [TripController::class, 'approve'])
        ->name('trip.approve');    

    Route::put("trips/cancel/{trip}", [TripController::class, 'cancel'])
        ->name('trip.cancel');   

    Route::resource('statuses', StatusController::class)
        ->only([
            'index',
        ]);
    
    Route::resource('destinations', DestinationController::class)
        ->only([
            'index',
        ]);
});


