<?php

namespace App\Contracts;

use App\Models\User;

interface TwoFactorRepositoryInterface
{
    public function enable(User $user, string $secret): User;

    public function disable(User $user): User;
}
