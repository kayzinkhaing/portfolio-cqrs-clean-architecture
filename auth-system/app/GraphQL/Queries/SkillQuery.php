<?php

namespace App\GraphQL\Queries;

use App\Services\SkillCacheService;

class SkillQuery
{
    protected SkillCacheService $cacheService;

    public function __construct(SkillCacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function all(): array
    {
        return $this->cacheService->fetchAll();
    }

    public function find($root, array $args): ?array
    {
        $id = $args['id'] ?? null;
        if (!$id) return null;

        return $this->cacheService->find($id);
    }
}
