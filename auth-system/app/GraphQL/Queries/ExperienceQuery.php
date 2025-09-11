<?php

namespace App\GraphQL\Queries;

use App\Services\ExperienceCacheService;

class ExperienceQuery
{
    protected ExperienceCacheService $cacheService;

    public function __construct(ExperienceCacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Get all experience records
     */
    public function all(): array
    {
        return $this->cacheService->fetchAll();
    }

    /**
     * Get a single experience record by ID
     */
    public function find($root, array $args): ?array
    {
        $id = $args['id'] ?? null;
        if (!$id) return null;

        return $this->cacheService->find($id);
    }
}
