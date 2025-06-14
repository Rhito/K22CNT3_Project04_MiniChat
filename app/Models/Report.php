<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'users_id',
        'participants_id',
        'report_type',
        'notes',
        'status',
    ];

    protected $casts = [
        'status' => 'string', // Maps enum 'open', 'closed'
        'created_at' => 'datetime',
    ];

    // User who filed the report
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Participant being reported
    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participants_id');
    }
}
