<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class SkillCategoryCacheService extends MongoCacheService
{
    public function __construct()
    {
        parent::__construct('skill_categories'); // Mongo collection name
    }

    protected function mapDocument($doc): array
    {
        $doc = json_decode(json_encode($doc), true);

        return [
            'id'         => $doc['id'] ?? (string)($doc['_id'] ?? ''),
            'name'       => $doc['name'] ?? null,
            'slug'       => $doc['slug'] ?? null,
            'created_at' => $doc['created_at'] ?? null,
            'updated_at' => $doc['updated_at'] ?? null,
        ];
    }
}
