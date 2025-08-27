<?php
namespace App\Jobs;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use MongoDB\Client as MongoClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncToReadModelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $modelClass;
    protected int $id;
    protected string $action;

    public function __construct(string $modelClass, int $id, string $action = 'update')
    {
        $this->modelClass = $modelClass;
        $this->id = $id;
        $this->action = $action;
    }

    public function handle()
    {
        Log::info("Mongo Job START: {$this->modelClass} ID {$this->id} ACTION {$this->action}");

        $mongo = new MongoClient('mongodb://mongo-db:27017'); // ✅ must match container name
        $db = $mongo->selectDatabase('read_model');

        $collectionName = Str::plural(strtolower(class_basename($this->modelClass)));
        $collection = $db->selectCollection($collectionName);

        if ($this->action === 'delete') {
            $collection->deleteOne(['id' => $this->id]);
            return;
        }

        $model = $this->modelClass::find($this->id);
        if (!$model) {
            Log::warning("Model {$this->modelClass} ID {$this->id} not found");
            return;
        }

        $data = $model->toArray();
        $collection->updateOne(
            ['id' => $this->id],
            ['$set' => $data],
            ['upsert' => true]
        );

        Log::info("Mongo Job DONE: {$this->modelClass} ID {$this->id}");
    }
}

