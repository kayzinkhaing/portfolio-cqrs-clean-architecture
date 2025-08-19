<?php

namespace App\Application\Commands;

use App\Models\User;

class VerifyTwoFactorCommand
{
    public function __construct(
        public User $user,
        public string $code
    ) {}
}
