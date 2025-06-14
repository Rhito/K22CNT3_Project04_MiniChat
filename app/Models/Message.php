<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'message_type',
    ];

    protected $casts = [
        'message_type' => 'string', // Maps enum 'text', 'image', 'file'
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Conversation the message belongs to
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }

    // Sender of the message
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Attachments for the message
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'messages_id');
    }

    // Users who deleted the message
    public function deletedBy()
    {
        return $this->hasMany(DeletedMessage::class, 'messages_id');
    }

    // Read receipts for the message
    public function readReceipts()
    {
        return $this->hasMany(ReadReceipt::class, 'messages_id');
    }
}
