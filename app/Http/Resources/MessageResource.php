<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\AttachmentResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'conversation_id' => $this->conversation_id,
            'sender_id' => $this->sender_id,
            'content' => $this->content,
            'message_type' => $this->message_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_deleted' => $this->is_deleted,
            'deleted_by' => $this->deleted_by,
            'deleted_at' => $this->deleted_at,
            'sender' => new UserResource($this->whenLoaded('sender')),
            'file_url' => $this->when($this->message_type !== 'text', fn () => $this->attachment->file_url ?? null),
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
        ];

    }
}
