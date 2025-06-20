<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\ReadReceipt;
use App\Models\Friendship;
use App\Models\Attachment;
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

        $receiverId = $conversation->participants()
            ->where('users_id', '!=', Auth::id())
            ->first()
            ?->id;

        $isBlocked = Friendship::where(function ($q) use ($receiverId) {
                $q->where('sender_id', $receiverId)
                ->where('receiver_id', Auth::id())
                ->where('status', 'blocked');
            })->orWhere(function ($q) use ($receiverId) {
                $q->where('sender_id', Auth::id())
                ->where('receiver_id', $receiverId)
                ->where('status', 'blocked');
            })->exists();

        if ($isBlocked) {
            return $this->error('You cannot send messages to this user.', null, 403);
        }

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
                'users_id' => Auth::id(),
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

    // 7. Upload attachment (image/file) many file can push to db at the same message
    public function upload(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'files' => 'required|array|min:1',
            'files.*' => 'file|max:10240', // max per file 10MB
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);
        $this->authorizeParticipant($conversation);

        // Create a message to group all the sent files.
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'content' => null,
            'message_type' => 'file',
        ]);

        $attachments = [];

        foreach ($request->file('files') as $file) {
            $path = $file->store('attachments', 'public');
            $url = Storage::url($path);

            $attachments[] = $message->attachments()->create([
                'file_path' => $path,
                'file_url' => $url,
                'file_type' => $file->getMimeType(),
            ]);
        }

        return $this->success([
            'message' => new MessageResource($message->load('sender', 'attachments')),
            'attachments' => $attachments,
        ], 'Files uploaded and message created');
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
