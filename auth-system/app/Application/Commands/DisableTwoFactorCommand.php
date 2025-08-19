<?php

namespace App\Application\Commands;

use App\Models\User;

class DisableTwoFactorCommand
{
    public function __construct(
        public User $user
    ) {}
}
