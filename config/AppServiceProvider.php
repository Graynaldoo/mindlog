<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\JournalRepositoryInterface;
use App\Repositories\JournalRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * Bind interface ke implementasi (Repository Pattern)
     */
    public function register(): void
    {
        $this->app->bind(
            JournalRepositoryInterface::class,
            JournalRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
