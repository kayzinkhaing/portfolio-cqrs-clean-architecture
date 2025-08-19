<?php

namespace App\Application\Handlers;

use App\Application\Commands\SendPasswordResetLinkCommand;
use App\Services\PasswordResetService;

class SendPasswordResetLinkHandler
{
    protected PasswordResetService $service;

    public function __construct(PasswordResetService $service)
    {
        $this->service = $service;
    }

    public function handle(SendPasswordResetLinkCommand $command)
    {
        return $this->service->sendResetLink($command->email);
    }
}
