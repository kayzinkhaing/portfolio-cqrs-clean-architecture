<?php

namespace App\Application\Handlers;

use App\Application\Commands\ResetPasswordCommand;
use App\Services\PasswordResetService;

class ResetPasswordHandler
{
    protected PasswordResetService $service;

    public function __construct(PasswordResetService $service)
    {
        $this->service = $service;
    }

    public function handle(ResetPasswordCommand $command)
    {
        return $this->service->resetPassword(
            $command->email,
            $command->token,
            $command->password
        );
    }
}
