<?php

namespace App\GraphQL\Queries;

use App\Services\ContactMessageCacheService;

class ContactMessageQuery
{
    protected ContactMessageCacheService $cacheService;

    public function __construct(ContactMessageCacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Get all contact messages
     */
    public function all(): array
    {
        return $this->cacheService->fetchAll();
    }

    /**
     * Get unread messages
     */
    public function unread(): array
    {
        return $this->cacheService->fetchUnread();
    }

    /**
     * Get a single message by ID
     */
    public function find($root, array $args): ?array
    {
        $id = $args['id'] ?? null;
        if (!$id) return null;

        return $this->cacheService->find($id);
    }
}
