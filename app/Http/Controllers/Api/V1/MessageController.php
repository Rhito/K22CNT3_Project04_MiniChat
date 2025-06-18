<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\ReadReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MessageResource;

class MessageController extends Controller
{
    use HttpResponses;

    // 0. Init or get private conversation between two users
    public function init(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id|different:auth',
        ]);

        $userId = Auth::id();
        $receiverId = $request->receiver_id;

        $conversation = Conversation::where('type', 'private')
            ->whereHas('participants', fn($q) => $q->where('users_id', $userId))
            ->whereHas('participants', fn($q) => $q->where('users_id', $receiverId))
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'type' => 'private',
                'created_by' => $userId,
            ]);
            $conversation->participants()->attach([$userId, $receiverId]);
        }

        return $this->success($conversation->load('participants'), 'Conversation initialized');
    }

    // 1. Get messages in a conversation
    public function index($id)
    {
        $conversation = Conversation::findOrFail($id);
        $this->authorizeParticipant($conversation);

        $messages = $conversation->messages()->with('sender')->latest()->paginate(30);

        return $this->success(MessageResource::collection($messages), 'Messages retrieved successfully');
    }

    // 2. Store new message
    public function store(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'content' => 'required_without:file|string|nullable',
            'message_type' => 'required|in:text,image,file',
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);
        $this->authorizeParticipant($conversation);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'content' => $request->content,
            'message_type' => $request->message_type,
        ]);

        return $this->success(new MessageResource($message->load('sender')), 'Message sent successfully');
    }

    // 3. Update a message
    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_id !== Auth::id()) {
            return $this->error('Unauthorized', null, 403);
        }

        $request->validate([
            'content' => 'required|string',
        ]);

        $message->update(['content' => $request->content]);

        return $this->success(new MessageResource($message), 'Message updated');
    }

    // 4. Delete a message
    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        if ($message->sender_id !== Auth::id()) {
            return $this->error('Unauthorized', null, 403);
        }

        $message->delete();

        return $this->success(null, 'Message deleted');
    }

    // 5. Mark message as seen
    public function seen($id)
    {
        $message = Message::findOrFail($id);

        // Store per-user read receipt instead of just updating message
        ReadReceipt::updateOrCreate(
            [
                'messages_id' => $message->id,
                'user_id' => Auth::id(),
            ],
            [
                'seen_at' => now(),
            ]
        );

        return $this->success(new MessageResource($message), 'Message marked as seen');
    }

    // 6. Typing indicator (broadcast event ideally)
    public function typing($id)
    {
        $conversation = Conversation::findOrFail($id);
        $this->authorizeParticipant($conversation);

        return $this->success(null, 'Typing event acknowledged');
    }

    // 7. Upload attachment (image/file)
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        $path = $request->file('file')->store('attachments', 'public');

        return $this->success([
            'url' => Storage::url($path),
            'path' => $path,
        ], 'File uploaded successfully');
    }

    protected function authorizeParticipant(Conversation $conversation)
    {
        $userId = Auth::id();
        $isParticipant = $conversation->participants()->where('users_id', $userId)->exists();

        if (!$isParticipant) {
            abort(403, 'You are not a participant of this conversation.');
        }
    }
}
