<?php

namespace App\GraphQL\Queries;

use App\Services\EducationCacheService;

class EducationQuery
{
    protected EducationCacheService $cacheService;

    public function __construct(EducationCacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Get all education records
     */
    public function all(): array
    {
        return $this->cacheService->fetchAll();
    }

    /**
     * Get active or unread-like records if you want
     */
    // public function active(): array
    // {
    //     // Example filter: only active educations (optional)
    //     return $this->cacheService->fetch(['status' => 'active'], 'educations_active');
    // }

    /**
     * Get a single education by ID
     */
    public function find($root, array $args): ?array
    {
        $id = $args['id'] ?? null;
        if (!$id) return null;

        return $this->cacheService->find($id);
    }
}
