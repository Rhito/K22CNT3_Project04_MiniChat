<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Friendship;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    use HttpResponses;

    // 1. Send friend request
    public function sendRequest(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id|different:auth',
        ]);

        $senderId = Auth::id();
        $receiverId = $request->receiver_id;

        $exists = Friendship::where(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($q) use ($senderId, $receiverId) {
            $q->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->first();

        if ($exists) {
            return $this->error('Friendship already exists', null, 409);
        }

        $friendship = Friendship::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending',
        ]);

        return $this->success($friendship, 'Friend request sent');
    }

    // 2. Get received friend requests
    public function receivedRequests()
    {
        $userId = Auth::id();
        $requests = Friendship::with('sender')
            ->where('receiver_id', $userId)
            ->where('status', 'pending')
            ->get();

        return $this->success($requests, 'Received friend requests');
    }

    // 3. Accept a friend request
    public function acceptRequest(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|exists:users,id',
        ]);

        $friendship = Friendship::where('sender_id', $request->sender_id)
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if (!$friendship) {
            return $this->error('Friend request not found', null, 404);
        }

        $friendship->update(['status' => 'accepted']);

        return $this->success($friendship, 'Friend request accepted');
    }

   // 4. Reject a friend request
   public function rejectRequest(Request $request, $id)
   {
       $friendship = Friendship::where('id', $id)
           ->where('receiver_id', Auth::id())
           ->where('status', 'pending')
           ->first();
        return $this->success([Auth::id(), $friendship], 'Friend request rejected');

       if (!$friendship) {
           return $this->error('Friend request not found', null, 404);
       }

       $friendship->update(['status' => 'rejected']);

       return $this->success(null, 'Friend request rejected');
   }

    // 5. List all accepted friends
    public function list()
    {
        $userId = Auth::id();

        $friends = Friendship::with(['sender', 'receiver'])
            ->where('status', 'accepted')
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
            })
            ->get()
            ->map(function ($f) use ($userId) {
                return $f->sender_id === $userId ? $f->receiver : $f->sender;
            });

        return $this->success($friends, 'Friend list retrieved');
    }

    // 6. Remove a friend
    public function remove($id)
    {
        $userId = Auth::id();

        $friendship = Friendship::where(function ($q) use ($userId, $id) {
            $q->where('sender_id', $userId)->where('receiver_id', $id);
        })->orWhere(function ($q) use ($userId, $id) {
            $q->where('sender_id', $id)->where('receiver_id', $userId);
        })->where('status', 'accepted')->first();

        if (!$friendship) {
            return $this->error('Friend not found', null, 404);
        }

        $friendship->delete();

        return $this->success(null, 'Friend removed successfully');
    }
        // 7. Block a user
        public function block($id)
        {
            $userId = Auth::id();

            $friendship = Friendship::updateOrCreate(
                [
                    'sender_id' => $userId,
                    'receiver_id' => $id,
                ],
                [
                    'status' => 'blocked',
                ]
            );

            return $this->success($friendship, 'User blocked successfully');
        }

        // 8. Unblock a user
        public function unblock($id)
        {
            $userId = Auth::id();

            $friendship = Friendship::where('sender_id', $userId)
                ->where('receiver_id', $id)
                ->where('status', 'blocked')
                ->first();

            if (!$friendship) {
                return $this->error('Blocked user not found', null, 404);
            }

            $friendship->delete();

            return $this->success(null, 'User unblocked successfully');
        }
}
