<?php

namespace App\Application\Handlers;

use App\Application\Commands\VerifyTwoFactorCommand;
use App\Services\TwoFactorService;

class VerifyTwoFactorHandler
{
    public function __construct(
        protected TwoFactorService $twoFactorService
    ) {}

    public function handle(VerifyTwoFactorCommand $command): bool
    {
        return $this->twoFactorService->verify($command->user, $command->code);
    }
}
