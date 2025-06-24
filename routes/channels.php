<?php

use Illuminate\Support\Facades\Broadcast;
Broadcast::routes(['middleware' => ['auth:sanctum']]);

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    // Kiểm tra nếu user là thành viên cuộc trò chuyện
    return \App\Models\Conversation::where('id', $conversationId)
        ->whereHas('participants', function ($q) use ($user) {
            $q->where('users_id', $user->id);
        })->exists();
});

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
