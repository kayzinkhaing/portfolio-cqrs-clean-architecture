<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Throwable;

trait RetryableAction
{
    /**
     * Retry a given callable with exponential backoff
     */
    public function retry(callable $action, int $maxRetries = 3, int $baseSleep = 100000)
    {
        $attempt = 0;

        while ($attempt < $maxRetries) {
            try {
                return $action();
            } catch (Throwable $e) {
                $attempt++;
                Log::error("Retry attempt {$attempt} failed: {$e->getMessage()}", [
                    'trace' => $e->getTraceAsString(),
                ]);

                // exponential backoff
                usleep($baseSleep * (2 ** ($attempt - 1)));

                if ($attempt >= $maxRetries) {
                    throw $e; // rethrow after max attempts
                }
            }
        }
    }
}
