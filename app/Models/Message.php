<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    // Nếu bạn muốn dùng soft delete mặc định của Laravel (option), dùng dòng sau:
    // use SoftDeletes;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'message_type',
        'is_deleted',
        'deleted_by',
        'deleted_at',
    ];

    protected $casts = [
        'message_type' => 'string', // 'text', 'image', 'file'
        'is_deleted' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
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

    // User who deleted the message (new, if you store only 1 user)
    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Attachments for the message
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'messages_id');
    }

    // Read receipts for the message
    public function readReceipts()
    {
        return $this->hasMany(ReadReceipt::class, 'messages_id');
    }

    // Optional legacy support: users who deleted this message (if using separate DeletedMessage table)
    public function deletedBy()
    {
        return $this->hasMany(DeletedMessage::class, 'messages_id');
    }
}
