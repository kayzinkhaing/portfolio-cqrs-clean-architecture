<?php

// app/Application/Handlers/UpdateProfileHandler.php
namespace App\Application\Handlers;

use App\Application\Commands\UpdateProfileCommand;
use App\Services\UserService;

class UpdateProfileHandler
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function handle(UpdateProfileCommand $command)
    {
        return $this->userService->updateProfile(
            $command->user,
            $command->data
        );
    }
}
