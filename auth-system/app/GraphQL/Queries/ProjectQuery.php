<?php

namespace App\GraphQL\Queries;

use App\Services\ProjectCacheService;

class ProjectQuery
{
    protected ProjectCacheService $cacheService;

    public function __construct(ProjectCacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Get all projects
     */
    public function all(): array
    {
        return $this->cacheService->fetchAll();
    }

    public function paginated($_, array $args)
    {
        $page = $args['page'] ?? 1;
        $perPage = $args['per_page'] ?? 10;

        return $this->cacheService->paginate($page, $perPage);
    }

    /**
     * Get a single project by ID
     */
    public function find($root, array $args): ?array
    {
        $id = $args['id'] ?? null;
        if (!$id) {
            return null;
        }

        return $this->cacheService->find($id);
    }
}
