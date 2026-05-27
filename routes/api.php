<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\ApiKeyController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\JournalController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\StatisticController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth:api', 'activity.log'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/regenerate-key', [AuthController::class, 'regenerateApiKey']);
    Route::post('/api-keys', [ApiKeyController::class, 'generate']);
    Route::delete('/api-keys/{apiKey}', [ApiKeyController::class, 'revoke']);

    Route::apiResource('journals', JournalController::class)->names('api.journals');
    Route::get('/journals/stats/weekly', [JournalController::class, 'weeklyStats']);
    Route::get('/journals/stats/monthly', [JournalController::class, 'monthlyStats']);
    Route::get('/moods', [JournalController::class, 'moods']);

    Route::apiResource('articles', ArticleController::class)->names('api.articles');
    Route::get('/education', [EducationController::class, 'index']);
    Route::post('/education', [EducationController::class, 'store']);
    Route::apiResource('categories', CategoryController::class)->names('api.categories');
    Route::get('/statistics', [AnalyticsController::class, 'statistics']);
    Route::get('/statistics/legacy', [StatisticController::class, 'user']);
    Route::get('/impact', [AnalyticsController::class, 'impact']);
    Route::get('/leaderboard', [LeaderboardController::class, 'index']);
});

Route::middleware(['basic.auth', 'activity.log'])->prefix('basic')->group(function () {
    Route::apiResource('journals', JournalController::class)->only(['index', 'show', 'store', 'update', 'destroy'])->names('api.basic.journals');
    Route::apiResource('articles', ArticleController::class)->only(['index', 'show'])->names('api.basic.articles');
    Route::apiResource('categories', CategoryController::class)->only(['index', 'show'])->names('api.basic.categories');
    Route::get('/statistics', [StatisticController::class, 'user']);
});

Route::middleware(['api.key', 'activity.log'])->prefix('key')->group(function () {
    Route::get('/validate', [ApiKeyController::class, 'validateKey']);
    Route::apiResource('journals', JournalController::class)->only(['index', 'show'])->names('api.key.journals');
    Route::apiResource('articles', ArticleController::class)->only(['index', 'show'])->names('api.key.articles');
    Route::get('/education', [EducationController::class, 'index']);
    Route::apiResource('categories', CategoryController::class)->only(['index', 'show'])->names('api.key.categories');
    Route::get('/statistics', [StatisticController::class, 'user']);
    Route::get('/impact', [AnalyticsController::class, 'impact']);
    Route::get('/leaderboard', [LeaderboardController::class, 'index']);
});
