<?php

namespace App\GraphQL\Queries;

use MongoDB\Client as MongoClient;

class EducationQuery
{
    /**
     * Fetch all education records
     */
    public function all(): array
    {
        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('educations');

        $cursor = $collection->find();
        $docs = iterator_to_array($cursor, false);

        return array_map(function ($d) {
            // Convert BSONDocument/BSONArray → associative array
            $doc = json_decode(json_encode($d), true);

            return [
                'id'          => isset($doc['id']) ? (string)$doc['id'] : (string)($doc['_id'] ?? ''),
                'user_id'     => $doc['user_id'] ?? null,
                'institution' => $doc['institution'] ?? null,
                'degree'      => $doc['degree'] ?? null,
                'location'    => $doc['location'] ?? null,
                'start_date'  => $doc['start_date'] ?? null,   // already string
                'end_date'    => $doc['end_date'] ?? null,     // already string
                'is_current'  => $doc['is_current'] ?? null,
                'details'     => $doc['details'] ?? null,
                'created_at'  => $doc['created_at'] ?? null,   // string
                'updated_at'  => $doc['updated_at'] ?? null,   // string
            ];
        }, $docs);
    }





    /**
     * Fetch a single education record by ID
     */
    public function find($root, array $args): ?array
    {
        $id = (int) ($args['id'] ?? 0);
        if (!$id) return null;

        $mongo = new MongoClient(env('MONGO_URL', 'mongodb://mongo:27017'));
        $collection = $mongo->selectDatabase('read_model')->selectCollection('educations');

        $doc = $collection->findOne(['id' => $id]);
        if (!$doc) return null;

        return [
            // 'id' => isset($doc->id) ? (int) $doc->id : null,
            'id' => $doc->id ?? $doc->_id ?? null,
            'user_id' => $doc->user_id ?? null,
            'institution' => $doc->institution ?? null,
            'degree' => $doc->degree ?? null,
            'location' => $doc->location ?? null,
            'start_date' => $doc->start_date ?? null,
            'end_date' => $doc->end_date ?? null,
            'is_current' => $doc->is_current ?? null,
            'details' => $doc->details ?? null,
            'created_at' => $doc->created_at ?? null,
            'updated_at' => $doc->updated_at ?? null,
        ];
    }
}
