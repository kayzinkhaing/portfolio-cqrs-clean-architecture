<?php

namespace App\Services;

use App\Contracts\UserRepositoryInterface;
use App\Jobs\SyncUserToReadModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    protected UserRepositoryInterface $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function register(array $data)
    {
        // Hash the password
        $data['password'] = Hash::make($data['password']);

        // Create user in MySQL
        $user = $this->userRepo->create($data);

        // Dispatch CQRS job to sync user to MongoDB read model
        SyncUserToReadModel::dispatch($user->id);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(array $credentials)
    {
        $user = $this->userRepo->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function updateProfile($user, array $data)
    {
        // Hash password only if provided
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // prevent overwriting with null
        }

        // Update user via repository
        $updatedUser = $this->userRepo->update($user->id, $data);

        // Load township & ward relationships
        return $updatedUser->load(['township', 'ward']);
    }
    public function logout($user)
    {
        // Revoke all tokens for this user
        $user->tokens()->delete();

        return true;
    }

}
