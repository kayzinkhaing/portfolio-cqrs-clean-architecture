<?php
namespace App\Application\Handlers;

use App\Application\Queries\CrudQuery;
use App\Services\CrudService;

class CrudQueryHandler
{
    public function handle(CrudQuery $query)
    {
        $service = new CrudService($query->model);
        $action = $query->action;
        $filters = $query->filters;

        return match($action) {
            'list' => $service->listAll(), // you could pass $filters if your service supports filtering
            'get' => $service->show((int)($filters['id'] ?? 0)),
            default => throw new \InvalidArgumentException("Unsupported query action: {$action}"),
        };
    }
}
