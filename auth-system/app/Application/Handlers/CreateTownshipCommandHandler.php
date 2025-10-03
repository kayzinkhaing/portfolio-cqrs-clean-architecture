<?php
namespace App\Application\Handlers;

use App\Application\Commands\CreateTownshipCommand;
use App\Services\TownshipService;

class CreateTownshipCommandHandler
{
    protected TownshipService $service;

    public function __construct(TownshipService $service)
    {
        $this->service = $service;
    }

    public function handle(CreateTownshipCommand $command)
    {
        return $this->service->create($command->data);
    }
}
