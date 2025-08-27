<?php
namespace App\GraphQL\Queries;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;

use MongoDB\Client as MongoClient;
use Illuminate\Support\Facades\Auth;

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
    // 1️⃣ Get the currently authenticated user from Laravel (Sanctum)
    $user = $context->request()->user('sanctum');

    if (!$user) {
        return null; // not logged in
    }

    // 2️⃣ Connect to MongoDB
    $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
    $db = $mongo->selectDatabase('read_model');

    // 3️⃣ Find the user document by email
    $collection = $db->selectCollection('users');
    $doc = $collection->findOne(['email' => $user->email]);
    // dd($doc); // Debugging line to check the document

    if (!$doc) return null;

    $arr = (array)$doc;

    // 4️⃣ Lookup township if township_id exists
    $township = null;
    if (isset($arr['township_id'])) {
        $townshipDoc = $db->selectCollection('townships')->findOne(['id' => (int)$arr['township_id']]);
        if ($townshipDoc) {
            $township = [
                'id' => (string)($townshipDoc['id'] ?? ''),
                'name' => $townshipDoc['name'] ?? null,
            ];
        }
    }

    // 5️⃣ Lookup ward if ward_id exists
    $ward = null;
    if (isset($arr['ward_id'])) {
        $wardDoc = $db->selectCollection('wards')->findOne(['id' => (int)$arr['ward_id']]);
        if ($wardDoc) {
            $ward = [
                'id' => (string)($wardDoc['id'] ?? ''),
                'name' => $wardDoc['name'] ?? null,
                'township_id' => (string)($township['id'] ?? ''),
            ];
        }
    }

$createdAt = null;
if (isset($doc['created_at'])) {
    if ($doc['created_at'] instanceof UTCDateTime) {
        $createdAt = $doc['created_at']->toDateTime()->format('Y-m-d H:i:s');
    } elseif (is_string($doc['created_at'])) {
        $createdAt = $doc['created_at'];
    }
}

$updatedAt = null;
if (isset($doc['updated_at'])) {
    if ($doc['updated_at'] instanceof UTCDateTime) {
        $updatedAt = $doc['updated_at']->toDateTime()->format('Y-m-d H:i:s');
    } elseif (is_string($doc['updated_at'])) {
        $updatedAt = $doc['updated_at'];
    }
}



    // 6️⃣ Return the user data in GraphQL format
    return [
        'id' => isset($arr['id']) ? (string)$arr['id'] : (string)$arr['_id'],
        'name' => $arr['name'] ?? null,
        'email' => $arr['email'] ?? null,
        'township' => $township,
        'ward' => $ward,
        'two_factor_enabled' => $arr['two_factor_enabled'] ?? false,

                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
    ];
}


}
