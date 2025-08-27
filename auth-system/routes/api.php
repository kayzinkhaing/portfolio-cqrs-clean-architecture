<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\WardController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\TownshipController;
use App\Http\Controllers\Api\TwoFactorController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TechnologyController;

// === Public Routes ===
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Forgot & Reset Password
Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])
        ->name('password.forgot');
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
        ->name('password.reset');

Route::apiResource('townships', TownshipController::class);
Route::apiResource('wards', WardController::class);

// Blog public routes
Route::apiResource('blogs', BlogController::class)->only(['index', 'show']);

Route::apiResource('statuses', StatusController::class);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('technologies', TechnologyController::class);

// === Protected Routes (Require Authentication) ===
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/2fa/enable', [TwoFactorController::class, 'enable']);
    Route::post('/2fa/verify', [TwoFactorController::class, 'verify']);
    Route::post('/2fa/disable', [TwoFactorController::class, 'disable']);

    // Authenticated user routes
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Blog management routes (only for logged-in users)
    Route::apiResource('blogs', BlogController::class)->only(['store', 'update', 'destroy']);
    Route::get('/users/{user}/blogs', [BlogController::class, 'userBlogs']);




});
