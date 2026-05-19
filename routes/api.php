<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JournalController;

/*
|--------------------------------------------------------------------------
| API Routes — MindLog
|--------------------------------------------------------------------------
|
| Base URL: /api
|
*/

// ── Auth (publik) ─────────────────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
});

// ── Protected: JWT Bearer Token ───────────────────────────────────────────
Route::middleware('auth:api')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('logout',           [AuthController::class, 'logout']);
        Route::post('refresh',          [AuthController::class, 'refresh']);
        Route::get('me',                [AuthController::class, 'me']);
        Route::post('regenerate-key',   [AuthController::class, 'regenerateApiKey']);
    });

    // Journals CRUD
    Route::apiResource('journals', JournalController::class);

    // Statistik
    Route::prefix('journals/stats')->group(function () {
        Route::get('weekly',  [JournalController::class, 'weeklyStats']);
        Route::get('monthly', [JournalController::class, 'monthlyStats']);
    });

    // Daftar mood
    Route::get('moods', [JournalController::class, 'moods']);
});

// ── Protected: API Key ────────────────────────────────────────────────────
Route::middleware('api.key')->prefix('v2')->group(function () {
    Route::get('journals',        [JournalController::class, 'index']);
    Route::get('journals/{id}',   [JournalController::class, 'show']);
    Route::get('moods',           [JournalController::class, 'moods']);
});
