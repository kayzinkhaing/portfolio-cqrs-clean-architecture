<?php
namespace App\Application\Handlers;

use App\Application\Commands\DeleteWardCommand;
use App\Services\WardService;

class DeleteWardHandler
{
    protected WardService $service;

    public function __construct(WardService $service)
    {
        $this->service = $service;
    }

    public function handle(DeleteWardCommand $command)
    {
        return $this->service->delete($command->id);
    }
}
