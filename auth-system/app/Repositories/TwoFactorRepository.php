<?php

namespace App\Repositories;

use App\Contracts\TwoFactorRepositoryInterface;
use App\Models\User;

class TwoFactorRepository implements TwoFactorRepositoryInterface
{
    public function enable(User $user, string $secret): User
    {
        $user->two_factor_secret = $secret;
        $user->two_factor_enabled = true;
        $user->save();

        return $user;
    }

    public function disable(User $user): User
    {
        $user->two_factor_secret = null;
        $user->two_factor_enabled = false;
        $user->save();

        return $user;
    }
}
