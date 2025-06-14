<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\FriendController;

// API Version 1
Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('v1.register');

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        // AUTHENTICATED
        Route::post('/logout', [AuthController::class, 'logout'])->name('v1.logout');
        Route::get('/user', [AuthController::class, 'user'])->name('v1.user');

        // FRIENDS ENDPOINT
        Route::prefix('friends')->group(function () {
            Route::post('request', [FriendController::class, 'sendRequest']);
            Route::get('requests', [FriendController::class, 'receivedRequests']);
            Route::post('accept', [FriendController::class, 'acceptRequest']);
            Route::delete('reject', [FriendController::class, 'rejectRequest']);
            Route::get('/', [FriendController::class, 'list']);
            Route::delete('{id}', [FriendController::class, 'remove']);
        });
    });
});
