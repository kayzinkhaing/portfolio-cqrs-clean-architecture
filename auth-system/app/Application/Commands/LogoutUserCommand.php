<?php
// app/Application/Commands/LogoutUserCommand.php
namespace App\Application\Commands;

use App\Models\User;

class LogoutUserCommand
{
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

