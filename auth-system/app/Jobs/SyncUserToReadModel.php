<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Services\RabbitPublisher;

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
        // Fetch user from MySQL
        $user = User::with(['township', 'ward'])->find($this->userId);
        if (!$user) return;

        // Prepare payload for RabbitMQ
        $payload = [
            'event' => 'user.upsert',
            'data' => [
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
            ],
            'meta' => [
                'source' => 'write-api',
                'action' => 'upsert',
            ],
        ];

        // ✅ Publish to RabbitMQ if service exists
        if (class_exists(RabbitPublisher::class)) {
            $publisher = app(RabbitPublisher::class);
            $publisher->publish('user.upsert', $payload);
        }

        // Optional: fallback to direct MongoDB sync if RabbitMQ is not configured
        // $mongo = new \MongoDB\Client('mongodb://mongo:27017');
        // $mongo->selectDatabase('read_model')->users->updateOne(
        //     ['id' => $user->id],
        //     ['$set' => $payload['data']],
        //     ['upsert' => true]
        // );
    }
}
