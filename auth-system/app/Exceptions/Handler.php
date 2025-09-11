<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed for validation exceptions.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     */
    public function report(Throwable $e): void
    {
        Log::error($e->getMessage(), [
            'exception' => get_class($e),
            'file'      => $e->getFile(),
            'line'      => $e->getLine(),
            'trace'     => $e->getTraceAsString(),
        ]);

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        if ($request->expectsJson()) {
            // Handle validation errors
            if ($e instanceof ValidationException) {
                return response()->json([
                    'error'    => 'ValidationError',
                    'message'  => 'The given data was invalid.',
                    'details'  => $e->errors(),
                ], 422);
            }

            // Handle not found
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'error'   => 'NotFound',
                    'message' => 'Resource not found.',
                ], 404);
            }

            // Handle unauthenticated
            if ($e instanceof AuthenticationException) {
                return response()->json([
                    'error'   => 'Unauthenticated',
                    'message' => 'You must be logged in to access this resource.',
                ], 401);
            }

            // Handle forbidden
            if ($e instanceof AuthorizationException) {
                return response()->json([
                    'error'   => 'Forbidden',
                    'message' => 'You are not authorized to perform this action.',
                ], 403);
            }

            // Handle HTTP exceptions
            if ($e instanceof HttpExceptionInterface) {
                return response()->json([
                    'error'   => class_basename($e),
                    'message' => $e->getMessage() ?: 'HTTP error occurred.',
                ], $e->getStatusCode());
            }

            // Generic 500 error for uncaught exceptions
            return response()->json([
                'error'   => 'ServerError',
                'message' => config('app.debug')
                    ? $e->getMessage() // detailed in debug mode
                    : 'Something went wrong. Please try again later.',
            ], 500);
        }

        // Default Laravel error page for non-API requests
        return parent::render($request, $e);
    }
}
