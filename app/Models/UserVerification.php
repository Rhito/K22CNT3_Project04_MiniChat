<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    protected $fillable = [
        'users_id',
        'verification_code',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // User associated with the verification
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
