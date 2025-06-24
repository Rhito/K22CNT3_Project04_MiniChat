<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletedConversation extends Model
{
    protected $fillable = [
        'conversation_id',
        'users_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Conversation that was deleted
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    // User who deleted the conversation
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
