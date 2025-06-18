<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\FriendController;
use App\Http\Controllers\Api\V1\MessageController;

// API Version 1
Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/login', [AuthController::class, 'login'])->name('v1.login');
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
            Route::patch('reject/{id}', [FriendController::class, 'rejectRequest']);
            Route::get('/', [FriendController::class, 'list']);
            Route::delete('{id}', [FriendController::class, 'remove']);
            Route::post('block/{id}', [FriendController::class, 'block']);
            Route::delete('unblock/{id}', [FriendController::class, 'unblock']);

        });

        // Messages
        Route::prefix('messages')->group(function(){
            Route::post('init', [MessageController::class, 'init']);
            Route::get('{id}', [MessageController::class, 'index']);
            Route::post('/', [MessageController::class, 'store']);
            Route::put('{id}', [MessageController::class, 'update']);
            Route::delete('{id}', [MessageController::class, 'destroy']);
            Route::post('seen/{id}', [MessageController::class, 'seen']);
            Route::post('typing/{id}', [MessageController::class, 'typing']);
            Route::post('upload', [MessageController::class, 'upload']);
        });

    });

});
