<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'messages_id',
        'file_name',
        'file_url',
        'file_path',
        'file_type',
        'thumb_url',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Message the attachment belongs to
    public function message()
    {
        return $this->belongsTo(Message::class, 'messages_id');
    }
}
