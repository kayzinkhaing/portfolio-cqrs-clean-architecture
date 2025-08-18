<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use MongoDB\Client as MongoClient;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        // Use the correct container name for MongoDB
        $mongo = new MongoClient('mongodb://mongo:27017');
        $db = $mongo->selectDatabase('read_model');
        $collection = $db->selectCollection('test_jobs');

        $collection->insertOne([
            'message' => $this->message,
            'created_at' => now(),
        ]);
    }
}
