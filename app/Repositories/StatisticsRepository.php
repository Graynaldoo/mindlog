<?php

namespace App\Repositories;

use App\Interfaces\StatisticsRepositoryInterface;
use App\Models\Article;
use App\Models\Journal;
use App\Models\Statistic;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class StatisticsRepository implements StatisticsRepositoryInterface
{
    public function recordJournal(int $userId): Statistic
    {
        return $this->incrementToday($userId, ['journals_count' => 1]);
    }

    public function recordArticleRead(int $userId, int $minutes = 5): Statistic
    {
        return $this->incrementToday($userId, [
            'articles_read' => 1,
            'learning_minutes' => max(1, $minutes),
            'digital_literacy_score' => 5,
        ]);
    }

    public function userSummary(int $userId): array
    {
        $last30Start = now()->subDays(29)->toDateString();
        $previousStart = now()->subDays(59)->toDateString();
        $previousEnd = now()->subDays(30)->toDateString();

        $last30 = Statistic::where('user_id', $userId)
            ->whereDate('activity_date', '>=', $last30Start)
            ->get();
        $previous30 = Statistic::where('user_id', $userId)
            ->whereBetween('activity_date', [$previousStart, $previousEnd])
            ->get();

        $currentActivity = $last30->sum('journals_count') + $last30->sum('articles_read');
        $previousActivity = $previous30->sum('journals_count') + $previous30->sum('articles_read');
        $growth = $previousActivity > 0
            ? round((($currentActivity - $previousActivity) / $previousActivity) * 100, 1)
            : ($currentActivity > 0 ? 100 : 0);

        $daily = collect(CarbonPeriod::create(now()->subDays(6), now()))
            ->map(function ($date) use ($userId) {
                $stat = Statistic::where('user_id', $userId)
                    ->whereDate('activity_date', $date->toDateString())
                    ->first();

                return [
                    'date' => $date->format('d M'),
                    'journals' => $stat?->journals_count ?? 0,
                    'articles' => $stat?->articles_read ?? 0,
                    'minutes' => $stat?->learning_minutes ?? 0,
                ];
            })
            ->values();

        return [
            'weekly_journals' => Journal::where('user_id', $userId)
                ->whereBetween('journal_date', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'articles_read' => $last30->sum('articles_read'),
            'daily_activity' => $last30->count(),
            'learning_minutes' => $last30->sum('learning_minutes'),
            'digital_literacy_score' => round($last30->avg('digital_literacy_score') ?? 0, 1),
            'activity_growth' => $growth,
            'report' => "Dalam 30 hari aktivitas pengguna meningkat {$growth}%",
            'daily_chart' => $daily,
        ];
    }

    public function impactDashboard(): array
    {
        $last30Start = now()->subDays(29)->toDateString();
        $previousStart = now()->subDays(59)->toDateString();
        $previousEnd = now()->subDays(30)->toDateString();

        $current = Statistic::whereDate('activity_date', '>=', $last30Start)->get();
        $previous = Statistic::whereBetween('activity_date', [$previousStart, $previousEnd])->get();

        $currentActivity = $current->sum('journals_count') + $current->sum('articles_read');
        $previousActivity = $previous->sum('journals_count') + $previous->sum('articles_read');
        $growth = $previousActivity > 0
            ? round((($currentActivity - $previousActivity) / $previousActivity) * 100, 1)
            : ($currentActivity > 0 ? 100 : 0);

        return [
            'users' => User::count(),
            'journals' => Journal::count(),
            'articles' => Article::count(),
            'published_articles' => Article::published()->count(),
            'articles_read' => $current->sum('articles_read'),
            'learning_minutes' => $current->sum('learning_minutes'),
            'activity_growth' => $growth,
            'report' => "Dalam 30 hari aktivitas pengguna meningkat {$growth}%",
            'category_reads' => Article::query()
                ->join('categories', 'articles.category_id', '=', 'categories.id')
                ->select('categories.name', DB::raw('SUM(articles.read_count) as total_reads'))
                ->groupBy('categories.name')
                ->orderByDesc('total_reads')
                ->limit(6)
                ->get(),
        ];
    }

    private function incrementToday(int $userId, array $increments): Statistic
    {
        $stat = Statistic::firstOrCreate(
            ['user_id' => $userId, 'activity_date' => today()->toDateString()],
            ['digital_literacy_score' => 0]
        );

        foreach ($increments as $column => $value) {
            $stat->increment($column, $value);
        }

        return $stat->fresh();
    }
}
