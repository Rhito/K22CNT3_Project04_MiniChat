<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        // Attempt to authenticate the user
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('Credentials do not match', '', 401);
        }

        // Retrieve the user
        $user = Auth::user();

        // Check if the account is active
        if (!$user->is_active) {
            return $this->error('Your account is inactive', '', 403);
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

}
