<?php
namespace App\Application\Handlers;

use App\Application\Commands\DeleteTownshipCommand;
use App\Services\TownshipService;

class DeleteTownshipHandler
{
    protected TownshipService $service;

    public function __construct(TownshipService $service)
    {
        $this->service = $service;
    }

    public function handle(DeleteTownshipCommand $command)
    {
        return $this->service->delete($command->id);
    }
}
