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
use Illuminate\Database\Eloquent\Relations\Relation;

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
        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo-db:27017'));
        $db = $mongo->selectDatabase('read_model');

        $collectionName = Str::plural(Str::snake(class_basename($this->modelClass)));
        $collection = $db->selectCollection($collectionName);

        if ($this->action === 'delete') {
            $collection->deleteOne(['id' => $this->id]);
            return;
        }

        $model = new $this->modelClass;

        // Dynamically detect relation methods
        $relationMethods = collect(get_class_methods($model))
            ->filter(fn($method) => method_exists($model, $method) && $model->$method() instanceof Relation)
            ->all();

        // Eager load all relations dynamically
        $entity = $this->modelClass::with($relationMethods)->find($this->id);

        if (!$entity) {
            Log::warning("Model {$this->modelClass} ID {$this->id} not found");
            return;
        }

        // Recursively include pivots for BelongsToMany and nested relations
        $this->includeRelations($entity);

        // Convert dates to ISO strings
        $data = $this->convertDates($entity->toArray());

        // Upsert into MongoDB
        $collection->updateOne(
            ['id' => $this->id],
            ['$set' => $data],
            ['upsert' => true]
        );
    }

    /**
     * Recursively convert pivot objects and nested relations
     */
    protected function includeRelations($model)
    {
        foreach ($model->getRelations() as $relationName => $relationData) {
            if ($relationData instanceof \Illuminate\Support\Collection) {
                foreach ($relationData as $item) {
                    if (isset($item->pivot)) {
                        $item->pivot = $item->pivot->toArray();
                    }
                    $this->includeRelations($item);
                }
            } elseif ($relationData instanceof \Illuminate\Database\Eloquent\Model) {
                if (isset($relationData->pivot)) {
                    $relationData->pivot = $relationData->pivot->toArray();
                }
                $this->includeRelations($relationData);
            }
        }
    }

    /**
     * Recursively convert Carbon dates to strings
     */
    protected function convertDates(array $data): array
    {
        foreach ($data as $key => $value) {
            if ($value instanceof \Illuminate\Support\Carbon) {
                $data[$key] = $value->toDateTimeString();
            } elseif (is_array($value)) {
                $data[$key] = $this->convertDates($value);
            }
        }
        return $data;
    }
}
