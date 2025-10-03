<?php
namespace App\Application\Handlers;

use App\Application\Commands\CreateWardCommand;
use App\Services\WardService;

class CreateWardCommandHandler
{
    protected WardService $service;

    public function __construct(WardService $service)
    {
        $this->service = $service;
    }

    public function handle(CreateWardCommand $command)
    {
        return $this->service->create($command->data);
    }
}
