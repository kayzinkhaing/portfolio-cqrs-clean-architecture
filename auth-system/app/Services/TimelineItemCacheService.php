<?php
namespace App\Services;

class TimelineItemCacheService extends MongoCacheService
{
    public function __construct()
    {
        parent::__construct('timeline_items');
    }

    protected function mapDocument($doc): array
    {
        $doc = json_decode(json_encode($doc), true);
        return [
            'id' => $doc['id'] ?? (string)($doc['_id'] ?? ''),
            'title' => $doc['title'] ?? null,
            'description' => $doc['description'] ?? null,
            'start_date' => $doc['start_date'] ?? null,
            'end_date' => $doc['end_date'] ?? null,
            'created_at' => $doc['created_at'] ?? null,
            'updated_at' => $doc['updated_at'] ?? null,
        ];
    }
}
