<?php

use App\Models\Ward;
use App\Models\Township;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WardController;
use App\Http\Controllers\Api\TownshipController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);

Route::apiResource('townships', TownshipController::class);
Route::apiResource('wards', WardController::class);

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->put('/update-profile', [AuthController::class, 'updateProfile']);
Route::middleware('auth:sanctum')->get('/profile', [AuthController::class, 'profile']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
