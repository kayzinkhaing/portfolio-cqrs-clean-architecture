<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Experience;
use MongoDB\Client;

class SyncExperienceToReadModel implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    protected int $id;
    protected string $action;

    public function __construct(int $id, string $action = 'update')
    {
        $this->id = $id;
        $this->action = $action;
    }

    public function handle()
    {
        $experience = Experience::find($this->id);
        if (!$experience) return;

        $client = new Client(env('MONGODB_URI', 'mongodb://mongo:27017'));
        $collection = $client->selectDatabase(env('MONGO_DB_DATABASE', 'read_model'))
                             ->selectCollection('experiences');

        $document = $experience->toArray();

        if ($this->action === 'update') {
            $collection->updateOne(
                ['_id' => $experience->id],
                ['$set' => $document],
                ['upsert' => true]
            );
        } elseif ($this->action === 'delete') {
            $collection->deleteOne(['_id' => $experience->id]);
        }
    }
}
