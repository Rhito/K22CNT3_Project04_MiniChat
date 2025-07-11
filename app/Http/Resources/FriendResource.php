<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FriendResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $authId = Auth::id();
        $friendship = $this->whenLoaded('friendship');

        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'avatar'     => $this->avatar,
            'is_active'  => $this->is_active,
            'is_blocked' => $friendship?->status === 'blocked' && $friendship->sender_id === $authId,
        ];
    }
}
