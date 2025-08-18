<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(array $data): array
    {
        /** @var User $user */
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'township_id' => $data['township_id'],
            'ward_id' => $data['ward_id'],
        ]);

        $user->load(['township', 'ward']);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ];
    }

    public function login(array $credentials): ?array
    {
        if (!Auth::attempt($credentials)) return null;

        /** @var User $user */
        $user = Auth::user();
        $user->load(['township', 'ward']);
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ];
    }

    public function updateProfile(User $user, array $data): User
    {
        $user->update($data);
        $user->load(['township', 'ward']);
        return $user;
    }

    public function logout(User $user): void
    {
        /** @var \Laravel\Sanctum\PersonalAccessToken $token */
        $token = $user->currentAccessToken();
        $token->delete();
    }
}

