<?php
namespace App\GraphQL\Queries;
use Illuminate\Support\Facades\Auth;

use MongoDB\Client as MongoClient;
use MongoDB\BSON\ObjectId;

class UserQuery
{
    public function all(): array
    {
        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('users');

        $docs = iterator_to_array($collection->find(), false);

        return array_map(function ($d) {
            $arr = (array) $d;

            // Always set ID (prefer 'id' if exists, otherwise _id)
            $id = isset($arr['id']) ? (string)$arr['id']
                : (isset($arr['_id']) ? (string)$arr['_id'] : null);

            return [
                'id' => $id,
                'name' => $arr['name'] ?? null,
                'email' => $arr['email'] ?? null,
                'township' => isset($arr['township']) ? [
                    'id' => (string)($arr['township']['id'] ?? ''),
                    'name' => $arr['township']['name'] ?? null
                ] : null,
                'ward' => isset($arr['ward']) ? [
                    'id' => (string)($arr['ward']['id'] ?? ''),
                    'name' => $arr['ward']['name'] ?? null,
                    'township_id' => (string)($arr['ward']['township_id'] ?? '')
                ] : null,
            ];
        }, $docs);
    }

    public function current($root, array $args, $context, $resolveInfo)
{
    // 1️⃣ Get the currently authenticated user from Laravel (JWT)
    $user = Auth::user();
    if (!$user) {
        return null; // not logged in
    }

    // 2️⃣ Connect to MongoDB
    $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
    $collection = $mongo->selectDatabase('read_model')->selectCollection('users');

    // 3️⃣ Find the user in MongoDB using their ID
    $doc = $collection->findOne(['id' => (int)$user->id]);
    if (!$doc) return null;

    $arr = (array)$doc;

    // 4️⃣ Return the user data in the expected GraphQL format
    return [
        'id' => isset($arr['id']) ? (string)$arr['id'] : (string)$arr['_id'],
        'name' => $arr['name'] ?? null,
        'email' => $arr['email'] ?? null,
        'township' => isset($arr['township']) ? [
            'id' => (string)($arr['township']['id'] ?? ''),
            'name' => $arr['township']['name'] ?? null,
        ] : null,
        'ward' => isset($arr['ward']) ? [
            'id' => (string)($arr['ward']['id'] ?? ''),
            'name' => $arr['ward']['name'] ?? null,
            'township_id' => (string)($arr['ward']['township_id'] ?? ''),
        ] : null,
        'two_factor_enabled' => $arr['two_factor_enabled'] ?? false,
        'created_at' => $arr['created_at'] ?? null,
        'updated_at' => $arr['updated_at'] ?? null,
    ];
}

}
