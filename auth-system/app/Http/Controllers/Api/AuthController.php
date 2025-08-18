<?php

namespace App\Http\Controllers\Api;

use App\Models\Ward;
use App\Models\Township;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;

class AuthController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // public function profile(Request $request)
    // {
    //     return new UserResource($request->user()->load(['township', 'ward']));
    // }

    public function profile(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => [
                'user' => new UserResource($request->user()->load(['township', 'ward'])),
            ]
        ]);
    }


    public function register(RegisterRequest $request)
    {
        $result = $this->userService->register($request->validated());

        // Load township and ward after creating user
        $user = $result['user']->load(['township', 'ward']);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully',
            'data' => [
                'user' => new UserResource($user),
                'token' => $result['token'],
                'token_type' => 'Bearer'
            ],
        ], 201);
    }



    public function login(LoginRequest $request)
    {
        $result = $this->userService->login($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user'  => new UserResource($result['user']->load(['township', 'ward'])),
                'token' => $result['token'],
                'token_type' => 'Bearer',
            ],
        ]);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $this->userService->updateProfile($request->user(), $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully!',
            'data'    => new UserResource($user),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully',
        ]);
    }
}
