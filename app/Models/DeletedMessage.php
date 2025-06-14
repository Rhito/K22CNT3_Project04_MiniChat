<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeletedMessage extends Model
{
    protected $fillable = [
        'messages_id',
        'users_id',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    // Message that was deleted
    public function message()
    {
        return $this->belongsTo(Message::class, 'messages_id');
    }

    // User who deleted the message
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
