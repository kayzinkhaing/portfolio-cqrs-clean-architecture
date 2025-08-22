<?php
namespace App\GraphQL\Queries;

use MongoDB\Client as MongoClient;

class WardQuery
{
    public function byTownship($root, array $args): array
    {
        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('wards');

        // Find wards where nested township.id matches (cast to int)
        $cursor = $collection->find(['township.id' => (int)$args['township_id']]);
        $docs = iterator_to_array($cursor, false);

        return array_map(function ($d) {
            $arr = (array)$d;

            return [
                'id' => isset($arr['id']) ? (int)$arr['id'] : null, // return integer
                'name' => $arr['name'] ?? null,
                'township' => isset($arr['township']) ? [
                    'id' => isset($arr['township']['id']) ? (int)$arr['township']['id'] : null, // integer
                    'name' => $arr['township']['name'] ?? null
                ] : null,
                'created_at' => $arr['created_at'] ?? null,
                'updated_at' => $arr['updated_at'] ?? null,
            ];
        }, $docs);
    }

    public function all(): array
    {
        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('wards');

        $cursor = $collection->find(); // no filter
        $docs = iterator_to_array($cursor, false);

        return array_map(function ($d) {
            return [
                'id' => isset($d->id) ? (int)$d->id : null,  // integer id
                'name' => $d->name ?? null,
                'township' => isset($d->township) ? [
                    'id' => isset($d->township['id']) ? (int)$d->township['id'] : null, // integer
                    'name' => $d->township['name'] ?? null
                ] : null,
                'created_at' => $d->created_at ?? null,
                'updated_at' => $d->updated_at ?? null,
            ];
        }, $docs);
    }
}
