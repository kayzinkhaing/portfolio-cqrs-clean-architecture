<?php

namespace App\Services;

class ExperienceCacheService extends MongoCacheService
{
    public function __construct()
    {
        parent::__construct('experiences'); // Mongo collection name
    }

    /**
     * Map Mongo document to array for Experience model
     */
    protected function mapDocument($doc): array
    {
        $doc = json_decode(json_encode($doc), true);

        return [
            'id'               => $doc['id'] ?? (string)($doc['_id'] ?? ''),
            'position'         => $doc['position'] ?? null,
            'company'          => $doc['company'] ?? null,
            'location'         => $doc['location'] ?? null,
            'start_date'       => $doc['start_date'] ?? null,
            'end_date'         => $doc['end_date'] ?? null,
            'responsibilities' => $doc['responsibilities'] ?? [],
            'created_at'       => $doc['created_at'] ?? null,
            'updated_at'       => $doc['updated_at'] ?? null,
        ];
    }
}
