<?php
namespace App\Application\Handlers;

use App\Application\Commands\UpdateWardCommand;
use App\Services\WardService;

class UpdateWardHandler
{
    protected WardService $service;

    public function __construct(WardService $service)
    {
        $this->service = $service;
    }

    public function handle(UpdateWardCommand $command)
    {
        return $this->service->update($command->id, $command->data);
    }
}
