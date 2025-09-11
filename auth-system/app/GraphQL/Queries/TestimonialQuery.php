<?php

namespace App\GraphQL\Queries;

use App\Services\TestimonialCacheService;

class TestimonialQuery
{
    protected TestimonialCacheService $cacheService;

    public function __construct(TestimonialCacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Get all testimonials
     */
    public function all(): array
    {
        return $this->cacheService->fetchAll();
    }

    /**
     * Get a single testimonial by ID
     */
    public function find($root, array $args): ?array
    {
        $id = $args['id'] ?? null;
        if (!$id) return null;

        return $this->cacheService->find($id);
    }
}
