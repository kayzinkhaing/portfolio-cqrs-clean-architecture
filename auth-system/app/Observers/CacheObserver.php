<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class CacheObserver
{
    /**
     * Refresh cache for the model using the corresponding CacheService
     */
    protected function refreshCacheFor(Model $model): void
    {
        // Derive CacheService class name
        $modelClass = get_class($model); // e.g., App\Models\Education
        $shortName  = class_basename($modelClass); // e.g., Education
        $serviceClass = "App\\Services\\{$shortName}CacheService";

        if (class_exists($serviceClass)) {
            $service = app($serviceClass);
            if (method_exists($service, 'refreshCache')) {
                $service->refreshCache();
            }
        }
    }

    public function created(Model $model): void
    {
        $this->refreshCacheFor($model);
    }

    public function updated(Model $model): void
    {
        $this->refreshCacheFor($model);
    }

    public function deleted(Model $model): void
    {
        $this->refreshCacheFor($model);
    }
}
