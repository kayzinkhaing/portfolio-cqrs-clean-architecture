<?php

namespace App\Application\Handlers;

use App\Application\Commands\LogoutUserCommand;
use App\Services\UserService;

class LogoutUserHandler
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function handle(LogoutUserCommand $command)
    {
        // Calls the service to logout the user (revoke token)
        return $this->userService->logout($command->user);
    }
}
