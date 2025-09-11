<?php

namespace App\Observers;

use App\Models\ContactMessage;
use App\Services\ContactMessageCacheService;

class ContactMessageObserver
{
    protected ContactMessageCacheService $cacheService;

    public function __construct(ContactMessageCacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function created(ContactMessage $message): void
    {
        $this->cacheService->refreshCache();
    }

    public function updated(ContactMessage $message): void
    {
        $this->cacheService->refreshCache();
    }

    public function deleted(ContactMessage $message): void
    {
        $this->cacheService->refreshCache();
    }
}
