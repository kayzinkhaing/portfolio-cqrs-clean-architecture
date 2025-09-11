<?php

namespace App\Listeners;

use App\Events\ModelChanged;
use App\Jobs\SyncToReadModelJob;

class SyncReadModelListener
{
    public function handle(ModelChanged $event)
    {
        $model = $event->model;

        // Load all relations dynamically if not loaded
        $model->loadMissing($model->getRelations());

        // Dispatch job with full model attributes and relations
        SyncToReadModelJob::dispatch(
            get_class($model),    // model class
            $model->toArray(),    // attributes + loaded relations
            $event->action
        )->afterCommit()
          ->onConnection('rabbitmq')
          ->onQueue('domain-events');
    }
}

