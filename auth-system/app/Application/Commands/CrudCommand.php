<?php
// app/Application/Commands/CrudCommand.php
namespace App\Application\Commands;

class CrudCommand
{
    public string $model;   // e.g. "Project"
    public string $action;  // e.g. "create", "update", "delete"
    public array $data;     // payload

    public function __construct(string $model, string $action, array $data = [])
    {
        $this->model = $model;
        $this->action = $action;
        $this->data = $data;
    }
}
