<?php

namespace App\Services;

class EducationCacheService extends MongoCacheService
{
    public function __construct()
    {
        parent::__construct('education'); // Mongo collection name
    }

    /**
     * Map Mongo document to array for Education model
     */
    protected function mapDocument($doc): array
    {
        $doc = json_decode(json_encode($doc), true);

        return [
            'id'          => $doc['id'] ?? (string)($doc['_id'] ?? ''),
            'degree'      => $doc['degree'] ?? null,
            'institution' => $doc['institution'] ?? null,
            'location'    => $doc['location'] ?? null,
            'start_date'  => $doc['start_date'] ?? null,
            'end_date'    => $doc['end_date'] ?? null,
            'details'     => $doc['details'] ?? null,
            'created_at'  => $doc['created_at'] ?? null,
            'updated_at'  => $doc['updated_at'] ?? null,
        ];
    }
}
