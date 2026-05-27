<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Interfaces\ArticleRepositoryInterface;
use App\Interfaces\JournalRepositoryInterface;
use App\Interfaces\StatisticsRepositoryInterface;
use App\Models\Category;
use App\Models\Mood;
use App\Repositories\StreakRepository;

class DashboardController extends Controller
{
    public function __construct(
        private JournalRepositoryInterface $journalRepo,
        private StreakRepository $streakRepo,
        private ArticleRepositoryInterface $articleRepo,
        private StatisticsRepositoryInterface $statisticsRepo,
    ) {}

    public function index()
    {
        $userId = auth()->id();

        return view('dashboard', [
            'streak' => $this->streakRepo->getByUser($userId),
            'todayJournal' => $this->journalRepo->getTodayJournal($userId),
            'weeklyMoods' => $this->journalRepo->getWeeklyMoodStats($userId),
            'monthlyStats' => $this->journalRepo->getMonthlyStats($userId),
            'recentJournals' => $this->journalRepo->getAllByUser($userId, 5),
            'moods' => Mood::all(),
            'todayMood' => $this->journalRepo->getTodayJournal($userId)?->mood,
            'latestArticles' => $this->articleRepo->latestPublished(4),
            'categories' => Category::withCount('articles')->where('is_active', true)->latest()->limit(6)->get(),
            'userStats' => $this->statisticsRepo->userSummary($userId),
            'impactStats' => $this->statisticsRepo->impactDashboard(),
        ]);
    }
}
