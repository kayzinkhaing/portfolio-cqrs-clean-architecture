<?php

namespace App\Listeners;

use App\Events\ContactMessageSyncedToMongo;
use App\Services\ContactMessageCacheService;

class RefreshContactMessageCache
{
    protected ContactMessageCacheService $cacheService;

    public function __construct(ContactMessageCacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function handle(ContactMessageSyncedToMongo $event): void
    {
        $this->cacheService->refreshCache();
    }
}
