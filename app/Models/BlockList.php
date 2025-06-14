<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockList extends Model
{
    protected $fillable = [
        'users_id',
        'blocked_user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // User who blocked someone
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // User who was blocked
    public function blockedUser()
    {
        return $this->belongsTo(User::class, 'blocked_user_id');
    }
}
