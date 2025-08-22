<?php
namespace App\GraphQL\Queries;

use MongoDB\Client as MongoClient;

class TownshipQuery
{
    public function all(): array
    {
        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('townships');

        // Find all documents
        $cursor = $collection->find();

        // Convert cursor to array
        $docs = iterator_to_array($cursor, false);

        // Map the documents
        return array_map(function ($d) {
            return [
                'id' => isset($d->id) ? (int) $d->id : null, // integer id
                'name' => $d->name ?? null,
                'wards' => $d->wards ?? [], // keep wards as is
            ];
        }, $docs);
    }
}
