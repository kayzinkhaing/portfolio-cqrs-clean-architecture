<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class SkillCacheService extends MongoCacheService
{
    public function __construct()
    {
        parent::__construct('skills'); // Mongo collection name
    }

    protected function mapDocument($doc): array
    {
        $doc = json_decode(json_encode($doc), true);

        return [
            'id'               => $doc['id'] ?? (string)($doc['_id'] ?? ''),
            'skill_category_id' => $doc['skill_category_id'] ?? null,
            'name'             => $doc['name'] ?? null,
            'level'            => $doc['level'] ?? 0,
            'icon'             => $doc['icon'] ?? null,
            'created_at'       => $doc['created_at'] ?? null,
            'updated_at'       => $doc['updated_at'] ?? null,
        ];
    }
}
