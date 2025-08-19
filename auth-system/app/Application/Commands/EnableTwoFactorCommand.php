<?php

namespace App\Application\Commands;

use App\Models\User;

class EnableTwoFactorCommand
{
    public function __construct(
        public User $user
    ) {}
}
