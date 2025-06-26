<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\FriendController;
use App\Http\Controllers\Api\V1\MessageController;
use App\Http\Controllers\Api\V1\GroupController;
use App\Http\Controllers\Api\V1\ConversationController;

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
        Route::patch('/user', [AuthController::class, 'editUser'])->name('v1.editUser');
        Route::post('/user/avatar', [AuthController::class, 'editAvatar'])->name('v1.editAvatar');

        Route::get('/conversation', [ConversationController::class, 'getAll']);
        // FRIENDS ENDPOINT
        Route::prefix('friends')->group(function () {
            // send a friend request
            Route::post('request', [FriendController::class, 'sendRequest']);

            // get list of requested to the current user
            Route::get('requests', [FriendController::class, 'receivedRequests']);

            // accept friend
            Route::post('accept', [FriendController::class, 'acceptRequest']);

            // reject friend requested
            Route::patch('reject/{id}', [FriendController::class, 'rejectRequest']);

            //Get list of friend
            Route::get('/', [FriendController::class, 'list']);

            // remove friendship
            Route::delete('{id}', [FriendController::class, 'remove']);

            // block a friend
            Route::post('block/{id}', [FriendController::class, 'block']);

            // unblock a friend
            Route::delete('unblock/{id}', [FriendController::class, 'unblock']);

            // Search friend
            Route::post('search', [FriendController::class, 'searchUser']);
        });

        // Messages
        Route::prefix('messages')->group(function(){
            // Innit a conversation
            Route::post('init', [MessageController::class, 'init']);

            // Get all the message by the id of conversation
            Route::get('{id}', [MessageController::class, 'index']);

            // Store new message
            Route::post('/', [MessageController::class, 'store']);

            // Edit the message
            Route::patch('{id}', [MessageController::class, 'update']);

            // Delete the message
            Route::delete('{id}', [MessageController::class, 'destroy']);

            // Seen them message by the id of message
            Route::post('seen/{id}', [MessageController::class, 'seen']);

            // typing in the conversation
            Route::post('typing/{id}', [MessageController::class, 'typing']);

            // Upload file
            Route::post('upload', [MessageController::class, 'upload']);

            // Search Mesage
            Route::post('search', [MessageController::class, 'search']);

        });

        // Group
        Route::prefix('groups')->group(function(){
            Route::post('init', [GroupController::class, 'store']); // Tạo nhóm
            Route::get('/', [GroupController::class, 'index']); // xem danh sach nhom
            Route::get('/{id}/gr', [GroupController::class, 'showGroup']); // xem nhom
            Route::patch('{id}', [GroupController::class, 'update']); // Cập nhật nhóm
            Route::post('{id}/members', [GroupController::class, 'addMembers']); // Thêm thành viên
            Route::delete('{id}/leave', [GroupController::class, 'leaveGroup']); // Rời nhóm

            Route::post('{id}/transfer-admin', [GroupController::class, 'transferAdmin']);
            Route::delete('{id}/kick-member', [GroupController::class, 'kickMember']);
            Route::post('search',[GroupController::class, 'search']);
        });
    });

});
