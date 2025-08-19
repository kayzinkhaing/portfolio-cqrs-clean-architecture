<?php

// app/Application/Commands/UpdateProfileCommand.php
namespace App\Application\Commands;

use App\Models\User;

class UpdateProfileCommand
{
    public User $user;
    public array $data;

    public function __construct(User $user, array $data)
    {
        $this->user = $user;
        $this->data = $data;
    }
}
