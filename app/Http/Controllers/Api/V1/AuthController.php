<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $remember = $request->remember_me ?? false;

        // Attempt to authenticate the user
        if (!Auth::attempt($credentials, $remember)) {
            return $this->error('Credentials do not match', '', 401);
        }

        // Retrieve the user
        $user = Auth::user();

        // Check if the account is active
        if (!$user->is_active) {
            return $this->error('Your account is inactive', '', 403);
        }

         // When use cookie/session (remember_me=true) then return the user
         if ($remember) {
            return $this->success([
                'user' => new UserResource($user),
            ], 'Đăng nhập thành công');
        }

        // Generate API token
        $token = $user->createToken('API Token of ' . $user->name)->plainTextToken;

        // Return success response
        return $this->success([
            'user' => new UserResource($user),
            'token' => $token,
        ], 'Login successful');
    }

    public function register(StoreUserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'avatar' => $request->avatar,
                'password' => Hash::make($request->password),
                'is_active' => 1,
            ]);

            $token = $user->createToken('API Token of ' . $user->name)->plainTextToken;


            return $this->success([
                'user' =>  new UserResource($user),
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return $this->error('Failed register', $e, 500);
        }
    }


    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->currentAccessToken()->delete();
            return $this->success(null, 'Logged out');
        }
        return $this->error('No authenticated user', null, 401);
    }

    public function user(Request $request){
        return new UserResource($request->user());
    }

    public function editUser(EditUserRequest $request)
    {
        if(!$request->all()){
            return $this->error('Request null!', null, 500);
        }
        // Lấy người dùng hiện tại
        $user = $request->user();

        // Chuẩn bị dữ liệu để cập nhật
        $data = [];

        if ($request->filled('password') || $request->filled('email')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return $this->error('Current password is incorrect.', null, 403);
            }
        }

        if ($request->filled('name')) {
            $data['name'] = $request->name;
        }

        if ($request->filled('email')) {
            $data['email'] = $request->email;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Xóa avatar cũ nếu có
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Lưu avatar mới
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }
        DB::beginTransaction();
        try {
            // Cập nhật người dùng
            $user->update($data);
            DB::commit();

            // Trả về phản hồi
            return $this->success([
                'id' => $user->id,
                'name' => $user->name,
                'password' => $user->password,
                'email' => $user->email,
                'avatar' => $user->avatar ? Storage::url($user->avatar) : null,
            ], 'User updated successfully');
        }
        catch(\Throwable $e){
            DB::rollback();
            return $this->error('Failed to update user: ' . $e->getMessage(), null, 500);
        }


    }

}
