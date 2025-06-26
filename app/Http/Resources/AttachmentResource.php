<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'message_id' => $this->message_id,
            'file_url' => $this->file_url,
            'file_path' => $this->file_path,
            'file_type' => $this->file_type,
            'uploaded_at' => $this->created_at,
        ];
    }
}
