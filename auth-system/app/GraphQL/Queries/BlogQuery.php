<?php
namespace App\GraphQL\Queries;

use MongoDB\Client as MongoClient;

class BlogQuery
{
    // List blogs with pagination and search
    public function all($root, array $args): array
    {
        $limit = $args['limit'] ?? 10;   // default 10 blogs
        $offset = $args['offset'] ?? 0;  // default start at 0
        $search = $args['search'] ?? null;

        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('blogs');

        // Build filter for search
        $filter = [];
        if ($search) {
            $filter = [
                '$or' => [
                    ['title' => ['$regex' => $search, '$options' => 'i']],
                    ['excerpt' => ['$regex' => $search, '$options' => 'i']],
                    ['content' => ['$regex' => $search, '$options' => 'i']],
                ]
            ];
        }

        $docs = iterator_to_array($collection->find($filter, [
            'sort' => ['created_at' => -1],
            'skip' => $offset,
            'limit' => $limit,
        ]), false);

        return array_map(function ($d) {
            $arr = (array) $d;

            return [
                'id' => isset($arr['id']) ? (string)$arr['id'] : (string)$arr['_id'],
                'title' => $arr['title'] ?? null,
                'excerpt' => $arr['excerpt'] ?? null,
                'content' => $arr['content'] ?? null,
                'published_at' => $arr['published_at'] ?? null,
                'created_at' => $arr['created_at'] ?? null,
                'updated_at' => $arr['updated_at'] ?? null,
                'user' => isset($arr['user']) ? [
                    'id' => (string)($arr['user']['id'] ?? ''),
                    'name' => $arr['user']['name'] ?? null,
                    'email' => $arr['user']['email'] ?? null,
                    'township' => isset($arr['user']['township']) ? [
                        'id' => (string)($arr['user']['township']['id'] ?? ''),
                        'name' => $arr['user']['township']['name'] ?? null,
                    ] : null,
                    'ward' => isset($arr['user']['ward']) ? [
                        'id' => (string)($arr['user']['ward']['id'] ?? ''),
                        'name' => $arr['user']['ward']['name'] ?? null,
                        'township_id' => (string)($arr['user']['ward']['township_id'] ?? ''),
                    ] : null,
                ] : null,
            ];
        }, $docs);
    }

    // Get a single blog by ID
    public function find($root, array $args)
    {
        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('blogs');

        $doc = $collection->findOne(['id' => (int)$args['id']]);
        if (!$doc) return null;

        $arr = (array)$doc;

        return [
            'id' => isset($arr['id']) ? (string)$arr['id'] : (string)$arr['_id'],
            'title' => $arr['title'] ?? null,
            'excerpt' => $arr['excerpt'] ?? null,
            'content' => $arr['content'] ?? null,
            'published_at' => $arr['published_at'] ?? null,
            'created_at' => $arr['created_at'] ?? null,
            'updated_at' => $arr['updated_at'] ?? null,
            'user' => isset($arr['user']) ? [
                'id' => (string)($arr['user']['id'] ?? ''),
                'name' => $arr['user']['name'] ?? null,
                'email' => $arr['user']['email'] ?? null,
                'township' => isset($arr['user']['township']) ? [
                    'id' => (string)($arr['user']['township']['id'] ?? ''),
                    'name' => $arr['user']['township']['name'] ?? null,
                ] : null,
                'ward' => isset($arr['user']['ward']) ? [
                    'id' => (string)($arr['user']['ward']['id'] ?? ''),
                    'name' => $arr['user']['ward']['name'] ?? null,
                    'township_id' => (string)($arr['user']['ward']['township_id'] ?? ''),
                ] : null,
            ] : null,
        ];
    }
}
