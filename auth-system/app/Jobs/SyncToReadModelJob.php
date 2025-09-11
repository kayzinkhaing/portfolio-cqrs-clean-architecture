<?php

namespace App\Jobs;

use App\Services\MongoService;
use App\Events\ModelChangedBroadcast;
use Illuminate\Support\Str;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Events\ContactMessageSyncedToMongo;

class SyncToReadModelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Model $model;
    protected string $action;

    // Retry settings
    public $tries = 5;
    public $backoff = [10, 30, 60];

    public function __construct(Model $model, string $action = 'update')
    {
        $this->model = $model;
        $this->action = $action;
    }

    public function handle()
    {
        try {
            $mongo = MongoService::getClient();
            $db = $mongo->selectDatabase('read_model');

            $collectionName = Str::plural(Str::snake(class_basename($this->model)));
            $collection = $db->selectCollection($collectionName);

            // Handle delete action
            if ($this->action === 'delete') {
                $collection->deleteOne(['id' => $this->model->id]);
                Log::info("Deleted {$collectionName} ID {$this->model->id} from MongoDB");

                event(new ModelChangedBroadcast(
                    get_class($this->model),
                    $this->model->id,
                    'delete',
                    ['id' => $this->model->id] // minimal payload
                ));

                return;
            }

            // Serialize model including relations
            $data = $this->serializeModel($this->model);

            // Upsert into Mongo
            $collection->updateOne(
                ['id' => $this->model->id],
                ['$set' => $data],
                ['upsert' => true]
            );

            ContactMessageSyncedToMongo::dispatch($data);

            Log::info("Synced {$collectionName} ID {$this->model->id} to MongoDB successfully");

            // Broadcast event for real-time frontend updates
            $payload = [
                'id' => $this->model->id,
                'name' => $this->model->name ?? null,
                'status' => $this->model->is_read ?? null,
            ];

            event(new ModelChangedBroadcast(
                get_class($this->model),
                $this->model->id,
                $this->action,
                $payload
            ));

        } catch (\Throwable $e) {
            Log::error("SyncToReadModelJob failed for ".get_class($this->model)." ID {$this->model->id}: {$e->getMessage()}");
            throw $e;
        }
    }

    /**
     * Recursively serialize model including relations and pivot data
     */
    protected function serializeModel(Model $model): array
    {
        $array = $model->toArray();

        foreach ($model->getRelations() as $relationName => $relationData) {
            if ($relationData instanceof \Illuminate\Support\Collection) {
                $array[$relationName] = $relationData->map(function ($item) {
                    if ($item instanceof Model) {
                        if (isset($item->pivot)) {
                            $item->pivot = $item->pivot->toArray();
                        }
                        return $this->serializeModel($item);
                    }
                    return $item;
                })->toArray();
            } elseif ($relationData instanceof Model) {
                if (isset($relationData->pivot)) {
                    $relationData->pivot = $relationData->pivot->toArray();
                }
                $array[$relationName] = $this->serializeModel($relationData);
            }
        }

        return $this->convertDates($array);
    }

    /**
     * Convert all Carbon instances to string recursively
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
