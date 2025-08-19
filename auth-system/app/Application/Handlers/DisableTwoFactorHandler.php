<?php

namespace App\Application\Handlers;

use App\Application\Commands\DisableTwoFactorCommand;
use App\Services\TwoFactorService;

class DisableTwoFactorHandler
{
    public function __construct(
        protected TwoFactorService $twoFactorService
    ) {}

    public function handle(DisableTwoFactorCommand $command): void
    {
        $this->twoFactorService->disable($command->user);
    }
}
