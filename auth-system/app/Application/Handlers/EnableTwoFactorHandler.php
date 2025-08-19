<?php

namespace App\Application\Handlers;

use App\Application\Commands\EnableTwoFactorCommand;
use App\Services\TwoFactorService;

class EnableTwoFactorHandler
{
    public function __construct(
        protected TwoFactorService $twoFactorService
    ) {}

    public function handle(EnableTwoFactorCommand $command): array
    {
        return $this->twoFactorService->enable($command->user);
    }
}
