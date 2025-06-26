<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\ReadReceipt;
use App\Models\Friendship;
use App\Models\Attachment;
use App\Models\DeletedMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MessageResource;
use App\Events\MessageSent;
use Carbon\Carbon;

class MessageController extends Controller
{
    use HttpResponses;

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

    public function index($id)
    {
        $conversation = Conversation::findOrFail($id);
        $this->authorizeParticipant($conversation);

        $userId = Auth::id();
        $messages = $conversation->messages()
        ->with('sender', 'attachments')
        ->whereDoesntHave('deletedBy', fn($q) => $q->where('users_id', $userId))
        ->latest()
        ->orderBy('id', 'asc')
        ->paginate(30)
        ->through(function ($message) {
            if ($message->is_deleted) {
                $message->content = 'Message has removed.';
            }
            return $message;
        });

        return $this->success(MessageResource::collection($messages), 'Messages retrieved successfully');
    }

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

        event(new MessageSent($message));
        return $this->success(new MessageResource($message->load('sender')), 'Message sent successfully');

    }

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

    public function destroy($id)
    {
        $message = Message::with('attachments')->findOrFail($id);

        if ($message->sender_id !== Auth::id()) {
            return $this->error('Unauthorized', null, 403);
        }

        // Nếu là tin nhắn file hoặc image → xoá file vật lý và DB record
        if (in_array($message->message_type, ['file', 'image'])) {
            foreach ($message->attachments as $attachment) {
                if ($attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
                    Storage::disk('public')->delete($attachment->file_path);
                }
                $attachment->delete(); // Xoá DB
            }
        }

        // Soft delete message
        $message->update([
            'is_deleted' => true,
            'deleted_by' => Auth::id(),
            'deleted_at' => now(),
        ]);

        return $this->success(new MessageResource($message->load('sender')), 'Message and attachments deleted');
    }


    public function hide($id)
    {
        $message = Message::findOrFail($id);
        $userId = Auth::id();

        // Nếu đã ẩn rồi thì bỏ qua
        $already = DeletedMessage::where('messages_id', $message->id)
            ->where('users_id', $userId)
            ->exists();

        if ($already) {
            return $this->success(null, 'Message already hidden');
        }

        DeletedMessage::create([
            'messages_id' => $message->id,
            'users_id' => $userId,
            'deleted_at' => Carbon::now(),
        ]);

        return $this->success(null, 'Message hidden for you');
    }


    public function seen($id)
    {
        $message = Message::findOrFail($id);

        ReadReceipt::updateOrCreate([
            'messages_id' => $message->id,
            'users_id' => Auth::id(),
        ]);

        return $this->success(new MessageResource($message), 'Message marked as seen');
    }

    public function typing($id)
    {
        $conversation = Conversation::findOrFail($id);
        $this->authorizeParticipant($conversation);

        return $this->success(null, 'Typing event acknowledged');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'files' => 'required|array|min:1',
            'files.*' => 'file|max:10240',
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);
        $this->authorizeParticipant($conversation);

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
        broadcast(new MessageSent($message->load('sender', 'attachments')));
        return $this->success([
            'message' => new MessageResource($message->load('sender', 'attachments')),
            'attachments' => $attachments,
        ], 'Files uploaded and message created');
    }

    public function search(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'keyword' => 'required|string|max:255',
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);
        $this->authorizeParticipant($conversation);

        $keyword = $request->keyword;
        $userId = Auth::id();

        $messages = Message::where('conversation_id', $conversation->id)
            ->where('content', 'like', "%{$keyword}%")
            ->whereDoesntHave('deletedBy', fn($q) => $q->where('users_id', $userId))
            ->with('sender')
            ->latest()
            ->paginate(30);

        return $this->success(MessageResource::collection($messages), 'Search results retrieved');
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
