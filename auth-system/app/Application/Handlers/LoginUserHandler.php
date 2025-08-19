<?php

// app/Application/Handlers/LoginUserHandler.php
namespace App\Application\Handlers;

use App\Application\Commands\LoginUserCommand;
use App\Services\UserService;

class LoginUserHandler
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function handle(LoginUserCommand $command)
    {
        return $this->userService->login([
            'email' => $command->email,
            'password' => $command->password
        ]);
    }

}
