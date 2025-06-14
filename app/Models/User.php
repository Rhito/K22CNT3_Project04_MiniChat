<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Friendships where user is the sender
    public function sentFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'sender_id');
    }

    // Friendships where user is the receiver
    public function receivedFriendRequests()
    {
        return $this->hasMany(Friendship::class, 'receiver_id');
    }

    // Accepted friends (bidirectional)
    public function friends()
    {
        return $this->belongsToMany(
            User::class,
            'friendships',
            'sender_id',
            'receiver_id'
        )->wherePivot('status', 'accepted');
    }

    // Messages sent by the user
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Conversations created by the user
    public function createdConversations()
    {
        return $this->hasMany(Conversation::class, 'created_by');
    }

    // Conversations the user participates in
    public function conversations()
    {
        return $this->belongsToMany(
            Conversation::class,
            'participants',
            'users_id',
            'conversation_id'
        )->withPivot('role', 'joined_at');
    }

    // Blocked users by this user
    public function blockedUsers()
    {
        return $this->hasMany(BlockList::class, 'users_id');
    }

    // Users who blocked this user
    public function blockedBy()
    {
        return $this->hasMany(BlockList::class, 'blocked_user_id');
    }

    // Conversations deleted by the user
    public function deletedConversations()
    {
        return $this->hasMany(DeletedConversation::class, 'users_id');
    }

    // Messages deleted by the user
    public function deletedMessages()
    {
        return $this->hasMany(DeletedMessage::class, 'users_id');
    }

    // Read receipts for messages
    public function readReceipts()
    {
        return $this->hasMany(ReadReceipt::class, 'users_id');
    }

    // Reports filed by the user
    public function reports()
    {
        return $this->hasMany(Report::class, 'users_id');
    }

    // Participations (for reports)
    public function participations()
    {
        return $this->hasMany(Participant::class, 'users_id');
    }

    // Verification record
    public function verification()
    {
        return $this->hasOne(UserVerification::class, 'users_id');
    }
}
