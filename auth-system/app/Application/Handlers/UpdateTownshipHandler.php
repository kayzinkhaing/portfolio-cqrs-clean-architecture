<?php
namespace App\Application\Handlers;

use App\Application\Commands\UpdateTownshipCommand;
use App\Services\TownshipService;

class UpdateTownshipHandler
{
    protected TownshipService $service;

    public function __construct(TownshipService $service)
    {
        $this->service = $service;
    }

    public function handle(UpdateTownshipCommand $command)
    {
        return $this->service->update($command->id, $command->data);
    }
}
