<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'title',
        'type',
        'created_by',
    ];

    protected $casts = [
        'type' => 'string', // Maps enum 'private', 'group'
        'created_at' => 'datetime',
    ];

    // User who created the conversation
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Participants in the conversation
    public function participants()
    {
        return $this->belongsToMany(
            User::class,
            'participants',
            'conversation_id',
            'users_id'
        )->withPivot('role', 'joined_at');
    }

    // Messages in the conversation
    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    // Deleted conversations
    public function deletedConversations()
    {
        return $this->hasMany(DeletedConversation::class, 'conversation_id');
    }
}
