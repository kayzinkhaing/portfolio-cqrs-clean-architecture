<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use MongoDB\Client as MongoClient;

class SyncUserToReadModel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function handle()
    {
        // Connect to MongoDB
        $mongo = new MongoClient('mongodb://mongo:27017');
        $db = $mongo->selectDatabase('read_model');
        $collection = $db->selectCollection('users');

        // Fetch only this user
        $user = User::with(['township', 'ward'])->find($this->userId);

        if (!$user) {
            return; // User not found
        }

        // Sync single user
        $collection->updateOne(
            ['id' => $user->id],
            [
                '$set' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'township' => $user->township ? [
                        'id' => $user->township->id,
                        'name' => $user->township->name,
                        'created_at' => $user->township->created_at?->toDateTimeString(),
                        'updated_at' => $user->township->updated_at?->toDateTimeString(),
                    ] : null,
                    'ward' => $user->ward ? [
                        'id' => $user->ward->id,
                        'name' => $user->ward->name,
                        'township_id' => $user->ward->township_id,
                        'created_at' => $user->ward->created_at?->toDateTimeString(),
                        'updated_at' => $user->ward->updated_at?->toDateTimeString(),
                    ] : null,
                    'created_at' => $user->created_at?->toDateTimeString(),
                    'updated_at' => $user->updated_at?->toDateTimeString(),
                ]
            ],
            ['upsert' => true]
        );
    }
}
