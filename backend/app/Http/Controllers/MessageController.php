<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'user_id' => $request->user()->id,
            'content' => $request->content,
        ]);

        $message->load('user');

        event(new MessageSent($message));

        return response()->json($message);
    }

    public function getMessages($conversationId)
    {
        $messages = Message::where('conversation_id', $conversationId)
            ->with('user')
            ->get();
        return response()->json($messages);
    }

    public function getConversations()
    {
        $conversations = auth()->user()->conversations()->with('messages.user')->get();
        return response()->json($conversations);
    }
}
