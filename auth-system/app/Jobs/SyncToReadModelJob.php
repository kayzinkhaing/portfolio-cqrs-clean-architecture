<?php

namespace App\Jobs;

use App\Services\MongoService;
use App\Events\ModelChangedBroadcast;
use App\Events\ContactMessageSyncedToMongo;
use Illuminate\Support\Str;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;

class SyncToReadModelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $modelClass;
    protected array $data;    // Full model + relations
    protected string $action;

    // Retry settings
    public $tries = 5;
    public $backoff = [10, 30, 60];

    public function __construct(string $modelClass, array $data, string $action = 'update')
    {
        $this->modelClass = $modelClass;
        $this->data = $this->convertDates($data); // Ensure Carbon -> string
        $this->action = $action;
    }

    public function handle()
    {
        try {
            $mongo = MongoService::getClient();
            $db = $mongo->selectDatabase(databaseName: 'read_model');

            $collectionName = Str::plural(Str::snake(class_basename($this->modelClass)));
            $collection = $db->selectCollection($collectionName);

            // Handle delete action
            if ($this->action === 'delete') {
                $usesSoftDeletes = in_array(
                    SoftDeletes::class,
                    class_uses_recursive($this->modelClass)
                );

                if ($usesSoftDeletes) {
                    // Mark as soft deleted in Mongo
                    $collection->updateOne(
                        ['id' => $this->data['id']],
                        ['$set' => ['deleted_at' => now()->toDateTimeString()]],
                        ['upsert' => true]
                    );
                    Log::info("Soft-deleted {$collectionName} ID {$this->data['id']} in MongoDB");
                } else {
                    // Hard delete in Mongo
                    $collection->deleteOne(['id' => $this->data['id']]);
                    Log::info("Hard-deleted {$collectionName} ID {$this->data['id']} from MongoDB");
                }

                event(new ModelChangedBroadcast(
                    $this->modelClass,
                    $this->data['id'],
                    'delete',
                    ['id' => $this->data['id']]
                ));

                return;
            }

            // Upsert the model + relations into MongoDB
            $collection->updateOne(
                ['id' => $this->data['id']],
                ['$set' => $this->data],
                ['upsert' => true]
            );

            // Dispatch optional event
            ContactMessageSyncedToMongo::dispatch($this->data);

            Log::info("Synced {$collectionName} ID {$this->data['id']} to MongoDB successfully");

            // Broadcast for frontend real-time updates
            $payload = [
                'id' => $this->data['id'],
                'name' => $this->data['name'] ?? null,
                'status' => $this->data['is_read'] ?? null,
            ];

            event(new ModelChangedBroadcast(
                $this->modelClass,
                $this->data['id'],
                $this->action,
                $payload
            ));

        } catch (\Throwable $e) {
            Log::error("SyncToReadModelJob failed for {$this->modelClass} ID {$this->data['id']}: {$e->getMessage()}");
            throw $e; // Let the queue retry
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
