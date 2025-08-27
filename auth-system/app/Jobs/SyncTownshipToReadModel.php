<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Township;
use MongoDB\Client as MongoClient;

class SyncTownshipToReadModel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $townshipId;
    public string $action;

    /**
     * Create a new job instance.
     *
     * @param int $townshipId
     * @param string $action 'update' or 'delete'
     */
    public function __construct(int $townshipId, string $action = 'update')
    {
        $this->townshipId = $townshipId;
        $this->action = $action;
    }

    public function handle()
    {
        // Connect to MongoDB
        $mongo = new MongoClient('mongodb://mongo:27017');
        $db = $mongo->selectDatabase('read_model');
        $collection = $db->selectCollection(collectionName: 'townships');

        if ($this->action === 'delete') {
            // Remove township from read model
            $collection->deleteOne(['id' => $this->townshipId]);
            return;
        }

        // Fetch township from MySQL
        $township = Township::with('wards')->find($this->townshipId);

        if (!$township) {
            return;
        }

        // Upsert township data into MongoDB
        $collection->updateOne(
            ['id' => $township->id],
            ['$set' => [
                'id' => $township->id,
                'name' => $township->name,
                'wards' => $township->wards->map(function ($ward) {
                    return [
                        'id' => $ward->id,
                        'name' => $ward->name,
                        'township_id' => $ward->township_id,
                        'created_at' => $ward->created_at?->toDateTimeString(),
                        'updated_at' => $ward->updated_at?->toDateTimeString(),
                    ];
                })->toArray(),
                'created_at' => $township->created_at?->toDateTimeString(),
                'updated_at' => $township->updated_at?->toDateTimeString(),
            ]],
            ['upsert' => true]
        );
    }
}
