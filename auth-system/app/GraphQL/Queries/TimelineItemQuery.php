<?php

namespace App\GraphQL\Queries;

use App\Services\TimelineItemCacheService;

class TimelineItemQuery
{
    protected TimelineItemCacheService $cacheService;

    public function __construct(TimelineItemCacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Get all timeline items
     */
    public function all(): array
    {
        return $this->cacheService->fetchAll();
    }

    /**
     * Get a single timeline item by ID
     */
    public function find($root, array $args): ?array
    {
        $id = $args['id'] ?? null;
        if (!$id) return null;

        return $this->cacheService->find($id);
    }
}
