<?php

namespace App\Traits;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

/**
 * Trait HandlesRepositoryErrors
 *
 * Provides a standardized way to handle exceptions in repositories.
 */
trait HandlesRepositoryErrors
{
    /**
     * Execute a repository operation safely with error handling.
     *
     * @param callable $callback
     * @param string|null $customMessage
     * @return mixed
     * @throws Exception
     */
    protected function handleErrors(callable $callback, ?string $customMessage = null)
    {
        try {
            // dd($callback);
            return $callback();
        } catch (ModelNotFoundException $e) {
            Log::error("Model not found: " . ($customMessage ?? $e->getMessage()), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);

            throw new ModelNotFoundException($customMessage ?? 'Resource not found.', 0, $e);
        } catch (QueryException $e) {
            // Log detailed query exception
            Log::error("Database query failed: " . ($customMessage ?? $e->getMessage()), [
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Correct way: re-throw the original QueryException with context
            throw $e;
        } catch (Exception $e) {
            Log::error("Unexpected repository error: " . ($customMessage ?? $e->getMessage()), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);

            throw new Exception($customMessage ?? 'An unexpected error occurred.', 0, $e);
        }
    }
}
