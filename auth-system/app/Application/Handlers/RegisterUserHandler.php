<?php

// app/Application/Handlers/RegisterUserHandler.php
namespace App\Application\Handlers;

use App\Application\Commands\RegisterUserCommand;
use App\Services\UserService;

class RegisterUserHandler
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function handle(RegisterUserCommand $command)
    {
        return $this->userService->register($command->data);
    }
}

// app/Application/Handlers/GetUserProfileHandler.php
// namespace App\Application\Handlers;

// use App\Application\Queries\GetUserProfileQuery;

// class GetUserProfileHandler
// {
//     public function handle(GetUserProfileQuery $query)
//     {
//         return $query->user->load(['township', 'ward']);
//     }
// }
