<?php

namespace App\Providers;

use App\Interfaces\ArticleRepositoryInterface;
use App\Interfaces\AnalyticsRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\EducationRepositoryInterface;
use App\Interfaces\JournalRepositoryInterface;
use App\Interfaces\StatisticsRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Article;
use App\Models\Category;
use App\Models\Journal;
use App\Policies\ArticlePolicy;
use App\Policies\CategoryPolicy;
use App\Policies\JournalPolicy;
use App\Repositories\ArticleRepository;
use App\Repositories\AnalyticsRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\EducationRepository;
use App\Repositories\JournalRepository;
use App\Repositories\StatisticsRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(JournalRepositoryInterface::class, JournalRepository::class);
        $this->app->bind(EducationRepositoryInterface::class, EducationRepository::class);
        $this->app->bind(AnalyticsRepositoryInterface::class, AnalyticsRepository::class);
        $this->app->bind(ArticleRepositoryInterface::class, ArticleRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(StatisticsRepositoryInterface::class, StatisticsRepository::class);
    }

    public function boot(): void
    {
        Gate::policy(Article::class, ArticlePolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Journal::class, JournalPolicy::class);

        Gate::define('manage-users', fn ($user) => $user->hasPermission('user.manage'));
        Gate::define('manage-articles', fn ($user) => $user->hasPermission('article.manage'));
        Gate::define('write-articles', fn ($user) => $user->hasPermission('article.create'));
        Gate::define('manage-categories', fn ($user) => $user->hasPermission('category.manage'));
        Gate::define('view-statistics', fn ($user) => $user->hasPermission('statistics.view'));
    }
}
