<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
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
            "conversation_id" => $this->conversation_id,
            "sender_id" => $this->sender_id,
            "content" => $this->content,
            "message_type" => $this->message_type,
            'sender' => new UserResource($this->whenLoaded('sender')),
        ];
    }
}
