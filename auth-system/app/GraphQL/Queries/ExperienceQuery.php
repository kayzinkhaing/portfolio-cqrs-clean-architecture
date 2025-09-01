<?php

namespace App\GraphQL\Queries;

use MongoDB\Client as MongoClient;

class ExperienceQuery
{
    /**
     * Fetch all experience records
     */
    public function all(): array
    {
        // Connect to MongoDB
        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('experiences');

        // Get all documents
        $cursor = $collection->find();
        $docs = iterator_to_array($cursor, false);

        // Map documents to clean associative arrays
        return array_map(function ($d) {
            // Convert BSONDocument/BSONArray → associative array
            $doc = json_decode(json_encode($d), true);

            return [
                'id'               => isset($doc['id']) ? (string)$doc['id'] : (string)($doc['_id'] ?? ''),
                // 'user_id'          => $doc['user_id'] ?? null,
                'position'         => $doc['position'] ?? null,
                'company'          => $doc['company'] ?? null,
                'location'         => $doc['location'] ?? null,
                'start_date'       => $doc['start_date'] ?? null,   // string
                'end_date'         => $doc['end_date'] ?? null,     // string
                // 'is_current'    => $doc['is_current'] ?? null,  // uncomment if needed
                'responsibilities' => $doc['responsibilities'] ?? null,
                'created_at'       => $doc['created_at'] ?? null,   // string
                'updated_at'       => $doc['updated_at'] ?? null,   // string
            ];
        }, $docs);
    }
}
