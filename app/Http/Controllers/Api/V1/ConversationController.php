<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    use HttpResponses;

    public function getAll()
    {
        $userId = Auth::id();

        $conversations = Conversation::with([
                'participants:id,name,avatar,email',
                'messages' => fn($q) => $q->latest()->limit(1),
            ])
            ->whereHas('participants', fn($q) => $q->where('users_id', $userId))
            ->orderByDesc(
                Message::select('created_at')
                    ->whereColumn('conversation_id', 'conversations.id')
                    ->latest()
                    ->take(1)
            )
            ->paginate(20);

        return $this->success($conversations, 'List of conversations', 200);
    }
}
