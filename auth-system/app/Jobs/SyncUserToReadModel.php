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

    public int $userId;
    public string $action;

    public function __construct(int $userId, string $action = 'update')
    {
        $this->userId = $userId;
        $this->action = $action;
    }

    public function handle()
    {
        $mongo = new MongoClient('mongodb://mongo:27017');
        $db = $mongo->selectDatabase('read_model');
        $collection = $db->selectCollection('users');

        if ($this->action === 'delete') {
            $collection->deleteOne(['id' => $this->userId]);
            return;
        }

        $user = User::with(['township', 'ward'])->find($this->userId);
        if (!$user) return;

        $collection->updateOne(
            ['id' => $user->id],
            ['$set' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'township' => $user->township ? [
                    'id' => $user->township->id,
                    'name' => $user->township->name,
                ] : null,
                'ward' => $user->ward ? [
                    'id' => $user->ward->id,
                    'name' => $user->ward->name,
                    'township_id' => $user->ward->township_id,
                ] : null,
                'created_at' => $user->created_at?->toDateTimeString(),
                'updated_at' => $user->updated_at?->toDateTimeString(),
            ]],
            ['upsert' => true]
        );
    }
}
