<?php
namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class ModelChanged
{
    use Dispatchable, SerializesModels;

    public Model $model;    // Full model instance
    public string $action;

    public function __construct(Model $model, string $action = 'update')
    {
        $this->model = $model;
        $this->action = $action;
    }
}

