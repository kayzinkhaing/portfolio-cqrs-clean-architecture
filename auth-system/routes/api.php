<?php

use App\Models\Ward;
use App\Models\Township;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\WardController;
use App\Http\Controllers\Api\TownshipController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
// === Public Routes ===
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('townships', TownshipController::class);
Route::apiResource('wards', WardController::class);

// Blog public routes
Route::apiResource('blogs', BlogController::class)->only(['index', 'show']);


// === Protected Routes (Require Authentication) ===
Route::middleware('auth:sanctum')->group(function () {
    // Authenticated user routes
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/update-profile', [AuthController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Blog management routes (only for logged-in users)
    Route::apiResource('blogs', BlogController::class)->only(['store', 'update', 'destroy']);
});

// Route::post('/login', [AuthController::class, 'login']);
// Route::middleware('auth:sanctum')->put('/update-profile', [AuthController::class, 'updateProfile']);
// Route::middleware('auth:sanctum')->get('/profile', [AuthController::class, 'profile']);
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
