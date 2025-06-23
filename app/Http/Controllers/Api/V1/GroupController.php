<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GroupRequest;
use App\Models\Conversation;
use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    use HttpResponses;

    protected function authorizeGroupAdmin(Conversation $group)
    {
        $participant = $group->participants()
            ->where('users_id', Auth::id())
            ->first();

        if (!$participant || $participant->pivot->role !== 'admin') {
            abort(403, 'Only group admins can perform this action.');
        }
    }

    public function store(GroupRequest $request)
    {
        $user = Auth::user();

        DB::beginTransaction();

        try {
            // 1. Lưu ảnh đại diện nhóm nếu có
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('group_avatars', 'public');
            }

            // 2. Tạo conversation kiểu group (có avatar)
            $conversation = Conversation::create([
                'title' => $request->title,
                'type' => 'group',
                'created_by' => $user->id,
                'avatar' => $avatarPath, // <-- gán luôn avatar
            ]);

            // 3. Gắn người tạo nhóm với vai trò admin
            $conversation->participants()->attach($user->id, [
                'role' => 'admin',
                'joined_at' => now(),
            ]);

            // 4. Gắn các thành viên khác (nếu có)
            if ($request->filled('member_ids')) {
                foreach ($request->member_ids as $memberId) {
                    $conversation->participants()->attach($memberId, [
                        'role' => 'member',
                        'joined_at' => now(),
                    ]);
                }
            }

            DB::commit();

            return $this->success([
                'conversation' => $conversation->load('participants:id,name,email,avatar'),
                'avatar' => $avatarPath ? Storage::url($avatarPath) : null,
            ], 'Group created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            return $this->error('Failed to create group: ' . $e->getMessage(), null, 500);
        }
    }

    public function index()
    {
        $user = Auth::user();

        $groups = $user->conversations()
            ->where('type', 'group')
            ->with(['participants:id,name,email,avatar'])
            ->latest('updated_at')
            ->get();

        return $this->success($groups, 'Group list retrieved.');
    }


    public function update(Request $request, $id)
    {
        $group = Conversation::findOrFail($id);
        $this->authorizeGroupAdmin($group);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($group->avatar) {
                Storage::disk('public')->delete($group->avatar);
            }
            $group->avatar = $request->file('avatar')->store('group_avatars', 'public');
        }

        if ($request->filled('title')) {
            $group->title = $request->title;
        }

        $group->save();

        return $this->success($group->load('participants'), 'Group updated.');
    }

    public function addMembers(Request $request, $id)
    {
        $group = Conversation::findOrFail($id);
        $this->authorizeGroupAdmin($group);

        $request->validate([
            'member_ids' => 'required|array',
            'member_ids.*' => 'exists:users,id',
        ]);

        foreach ($request->member_ids as $memberId) {
            $group->participants()->syncWithoutDetaching([
                $memberId => ['role' => 'member', 'joined_at' => now()]
            ]);
        }

        return $this->success($group->load(), 'Members added.');
    }

    // User leave not kicked
    public function leaveGroup($id)
    {
        $group = Conversation::findOrFail($id);
        $userId = Auth::id();

        if ($group->created_by == $userId) {
            return $this->error('admin cannot leave the group.', null, 403);
        }

        $group->participants()->detach($userId);

        return $this->success(null, 'You have left the group.');
    }

    public function destroy($id)
    {
        $group = Conversation::findOrFail($id);
        $this->authorizeGroupAdmin($group);

        // Xoá ảnh đại diện nếu có
        if ($group->avatar) {
            Storage::disk('public')->delete($group->avatar);
        }

        // Xoá nhóm
        $group->delete();

        return $this->success(null, 'Group deleted.');
    }

    public function transferAdmin(Request $request, $id)
    {
        $group = Conversation::findOrFail($id);
        $this->authorizeGroupAdmin($group);

        $request->validate([
            'new_admin_id' => 'required|exists:users,id',
        ]);

        $newAdminId = $request->new_admin_id;

        // Kiểm tra thành viên mới có trong nhóm chưa
        $participant = $group->participants()->where('users_id', $newAdminId)->first();

        if (!$participant) {
            return $this->error('User is not in the group.', null, 422);
        }

        // Cập nhật quyền
        $group->participants()->updateExistingPivot(Auth::id(), ['role' => 'member']);
        $group->participants()->updateExistingPivot($newAdminId, ['role' => 'admin']);

        return $this->success(null, 'Admin role transferred.');
    }

    public function kickMember(Request $request, $id)
    {
        $group = Conversation::findOrFail($id);
        $this->authorizeGroupAdmin($group);

        $request->validate([
            'member_id' => 'required|exists:users,id',
        ]);

        $memberId = $request->member_id;

        // Không được tự kick admin (hoặc chính mình)
        if ($memberId == Auth::id()) {
            return $this->error('You cannot kick yourself.', null, 403);
        }

        $participant = $group->participants()->where('users_id', $memberId)->first();

        if (!$participant) {
            return $this->error('User is not in the group.', null, 422);
        }

        $group->participants()->detach($memberId);

        return $this->success(null, 'Member kicked.');
    }



}
