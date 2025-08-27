<?php
namespace App\Application\Queries;

class CrudQuery
{
    public string $model;    // e.g. "Status"
    public string $action;   // e.g. "list", "get"
    public array $filters;   // query filters

    public function __construct(string $model, string $action, array $filters = [])
    {
        $this->model = $model;
        $this->action = $action;
        $this->filters = $filters;
    }
}
