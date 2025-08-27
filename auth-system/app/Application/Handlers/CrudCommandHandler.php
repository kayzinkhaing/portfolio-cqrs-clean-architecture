<?php
namespace App\Application\Handlers;

use App\Application\Commands\CrudCommand;
use App\Services\CrudService;

class CrudCommandHandler
{
    public function handle(CrudCommand $command)
    {
        $service = new CrudService($command->model);
        // dd($service);
        $action = $command->action;
        $data = $command->data;

        return match($action) {
            'create' => $service->create($data),
            'update' => $service->update((int)($data['id'] ?? 0), $data),
            'delete' => $service->delete((int)($data['id'] ?? 0)),
            default => throw new \InvalidArgumentException("Unsupported action: {$action}"),
        };
    }
}
