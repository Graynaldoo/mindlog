<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\Admin\UserController as AdminUserController;
use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\JournalController;
use App\Http\Controllers\Web\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified', 'activity.log'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('journal', JournalController::class);
    Route::post('/mood/set', [JournalController::class, 'setMood'])->name('mood.set');

    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/manage', [ArticleController::class, 'manage'])->name('articles.manage');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
    Route::get('/learn/{slug}', [ArticleController::class, 'show'])->name('articles.show');

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::resource('users', AdminUserController::class)->only(['index', 'update', 'destroy']);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/logout-success', function () {
    if (!session()->has('logout_name')) {
        return redirect()->route('login');
    }
    return view('auth.logout-success');
})->name('logout.success');

require __DIR__ . '/auth.php';
