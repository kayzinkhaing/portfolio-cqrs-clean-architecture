<?php

namespace App\Services;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class PasswordResetService
{
    public function sendResetLink(string $email): bool
    {
        $status = Password::sendResetLink(['email' => $email]);
        return $status === Password::RESET_LINK_SENT;
    }

    public function resetPassword(string $email, string $token, string $password): bool
    {
        $status = Password::reset(
            ['email' => $email, 'token' => $token, 'password' => $password, 'password_confirmation' => $password],
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET;
    }
}

