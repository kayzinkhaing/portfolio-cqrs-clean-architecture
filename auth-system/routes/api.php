<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\WardController;
use App\Http\Controllers\Api\SkillController;
use App\Http\Controllers\Api\SkillsController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TownshipController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\TwoFactorController;
use App\Http\Controllers\Api\ExperienceController;
use App\Http\Controllers\Api\TechnologyController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\TimelineItemController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\SkillCategoryController;
use App\Http\Controllers\Api\ContactMessageController;

// === Public Routes ===
Route::post('/register', action: [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//refresh-tokens
Route::post('/refresh-token', [AuthController::class, 'refreshToken']);
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
Route::apiResource('skill-cat', SkillCategoryController::class);
Route::apiResource('skills', SkillController::class);
Route::apiResource('testimonials', TestimonialController::class);
Route::apiResource('timeline-items', TimelineItemController::class);
Route::apiResource('pages', PageController::class);
Route::apiResource('educations', EducationController::class);
Route::apiResource('experiences', ExperienceController::class);
Route::apiResource('contact-messages', ContactMessageController::class);



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
