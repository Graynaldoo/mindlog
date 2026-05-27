<?php

namespace App\Repositories;

use App\Interfaces\AnalyticsRepositoryInterface;
use App\Models\Activity;
use App\Models\Article;
use App\Models\EducationContent;
use App\Models\ImpactMetric;
use App\Models\Journal;
use App\Models\Statistic;
use App\Models\Streak;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnalyticsRepository implements AnalyticsRepositoryInterface
{
    public function statistics(?int $userId = null): array
    {
        $journalQuery = Journal::query()->when($userId, fn ($query) => $query->where('user_id', $userId));
        $activityQuery = Activity::query()->when($userId, fn ($query) => $query->where('user_id', $userId));

        return [
            'total_journal' => (clone $journalQuery)->count(),
            'average_productivity' => round((clone $journalQuery)->avg('productivity_score') ?? 0, 2),
            'average_activity_minutes' => round((clone $activityQuery)->avg('duration_minutes') ?? 0, 2),
            'weekly_mood' => (clone $journalQuery)
                ->with('mood')
                ->whereBetween('journal_date', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
                ->orderBy('journal_date')
                ->get()
                ->map(fn (Journal $journal) => [
                    'date' => $journal->journal_date->format('Y-m-d'),
                    'mood' => $journal->mood?->name,
                    'score' => $journal->mood?->score ?? 0,
                ]),
            'usage' => Statistic::query()
                ->when($userId, fn ($query) => $query->where('user_id', $userId))
                ->whereDate('activity_date', '>=', now()->subDays(29)->toDateString())
                ->selectRaw('SUM(journals_count) as journals, SUM(articles_read) as articles, SUM(learning_minutes) as minutes')
                ->first(),
        ];
    }

    public function impact(): array
    {
        $metric = $this->recalculateImpactMetric();
        $improvedUsers = $this->productivityImprovedPercentage();

        return [
            'metric' => $metric,
            'message' => "{$improvedUsers}% pengguna menunjukkan peningkatan produktivitas berdasarkan jurnal dan aktivitas 30 hari terakhir.",
            'productivity_improved_percentage' => $improvedUsers,
        ];
    }

    public function leaderboard(): array
    {
        return [
            'most_active_users' => Statistic::query()
                ->join('users', 'statistics.user_id', '=', 'users.id')
                ->select('users.id', 'users.name', DB::raw('SUM(journals_count + articles_read) as score'))
                ->groupBy('users.id', 'users.name')
                ->orderByDesc('score')
                ->limit(10)
                ->get(),
            'most_journals' => Journal::query()
                ->join('users', 'journals.user_id', '=', 'users.id')
                ->select('users.id', 'users.name', DB::raw('COUNT(journals.id) as journal_count'))
                ->groupBy('users.id', 'users.name')
                ->orderByDesc('journal_count')
                ->limit(10)
                ->get(),
            'most_consistent' => Streak::query()
                ->join('users', 'streaks.user_id', '=', 'users.id')
                ->select('users.id', 'users.name', 'streaks.current_streak', 'streaks.longest_streak')
                ->orderByDesc('streaks.current_streak')
                ->orderByDesc('streaks.longest_streak')
                ->limit(10)
                ->get(),
        ];
    }

    public function recalculateImpactMetric(): ImpactMetric
    {
        $totalUsers = User::count();
        $activeUsers = User::whereHas('journals', fn ($query) => $query->whereDate('journal_date', '>=', now()->subDays(29)->toDateString()))
            ->orWhereHas('statistics', fn ($query) => $query->whereDate('activity_date', '>=', now()->subDays(29)->toDateString()))
            ->count();

        return ImpactMetric::create([
            'total_user' => $totalUsers,
            'total_journal' => Journal::count(),
            'average_productivity' => round(Journal::where('productivity_score', '>', 0)->avg('productivity_score') ?? 0, 2),
            'education_content_read' => EducationContent::sum('read_count') + Article::sum('read_count'),
            'engagement_rate' => $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 2) : 0,
            'calculated_at' => now(),
        ]);
    }

    private function productivityImprovedPercentage(): float
    {
        $users = User::whereHas('journals')->get();
        if ($users->isEmpty()) {
            return 0;
        }

        $improved = $users->filter(function (User $user) {
            $current = Journal::where('user_id', $user->id)
                ->whereDate('journal_date', '>=', now()->subDays(29)->toDateString())
                ->avg('productivity_score') ?? 0;
            $previous = Journal::where('user_id', $user->id)
                ->whereBetween('journal_date', [now()->subDays(59)->toDateString(), now()->subDays(30)->toDateString()])
                ->avg('productivity_score') ?? 0;

            return $current > 0 && ($previous === 0.0 || $current > $previous);
        })->count();

        return round(($improved / $users->count()) * 100, 2);
    }
}
