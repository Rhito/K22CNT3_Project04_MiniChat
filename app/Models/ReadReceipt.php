<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadReceipt extends Model
{
    protected $fillable = [
        'messages_id',
        'users_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Message that was read
    public function message()
    {
        return $this->belongsTo(Message::class, 'messages_id');
    }

    // User who read the message
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
