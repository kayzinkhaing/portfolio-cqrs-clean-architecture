<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Ward;
use MongoDB\Client as MongoClient;

class SyncWardToReadModel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $wardId;
    public string $action;

    public function __construct(int $wardId, string $action = 'update')
    {
        $this->wardId = $wardId;
        $this->action = $action;
    }

    public function handle()
    {
        $mongo = new MongoClient('mongodb://mongo:27017');
        $db = $mongo->selectDatabase('read_model');
        $collection = $db->selectCollection('wards');

        if ($this->action === 'delete') {
            $collection->deleteOne(['id' => $this->wardId]);
            return;
        }

        $ward = Ward::with('township')->find($this->wardId);
        if (!$ward) return;

        $collection->updateOne(
            ['id' => $ward->id],
            ['$set' => [
                'id' => $ward->id,
                'name' => $ward->name,
                'township' => $ward->township ? [
                    'id' => $ward->township->id,
                    'name' => $ward->township->name,
                ] : null,
                'created_at' => $ward->created_at?->toDateTimeString(),
                'updated_at' => $ward->updated_at?->toDateTimeString(),
            ]],
            ['upsert' => true]
        );
    }
}
