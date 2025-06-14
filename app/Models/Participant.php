<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'conversation_id',
        'users_id',
        'role',
        'joined_at',
    ];

    protected $casts = [
        'role' => 'string', // Maps enum 'member', 'admin'
        'joined_at' => 'datetime',
    ];

    // Conversation the participant is in
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    // User who is the participant
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Reports related to this participant
    public function reports()
    {
        return $this->hasMany(Report::class, 'participants_id');
    }
}
