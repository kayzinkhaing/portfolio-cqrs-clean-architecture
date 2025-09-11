<?php

namespace App\Services;

use MongoDB\Client as MongoClient;

class MongoService
{
    private static ?MongoClient $client = null;

    public static function getClient(): MongoClient
    {
        if (self::$client === null) {
            self::$client = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        }
        return self::$client;
    }
}
