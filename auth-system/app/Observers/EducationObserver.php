<?php

namespace App\Observers;

use App\Models\Education;
use App\Services\EducationCacheService;

class EducationObserver
{
    protected EducationCacheService $cacheService;

    public function __construct(EducationCacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function created(Education $education): void
    {
        $this->cacheService->refreshCache();
    }

    public function updated(Education $education): void
    {
        $this->cacheService->refreshCache();
    }

    public function deleted(Education $education): void
    {
        $this->cacheService->refreshCache();
    }
}
