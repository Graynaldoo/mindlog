<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\JournalRepository;
use App\Repositories\StreakRepository;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function __construct(
        private JournalRepository $journalRepo,
        private StreakRepository  $streakRepo,
    ) {}

    public function index()
    {
        $userId  = auth()->id();

        $streak        = $this->streakRepo->getByUser($userId);
        $todayJournal  = $this->journalRepo->getTodayJournal($userId);
        $weeklyMoods   = $this->journalRepo->getWeeklyMoodStats($userId);
        $monthlyStats  = $this->journalRepo->getMonthlyStats($userId);
        $recentJournals = $this->journalRepo->getAllByUser($userId, 5);
        
        $moods = \App\Models\Mood::all();
        $todayMood = $todayJournal ? $todayJournal->mood : null;

        // Quote motivasi dari public API
        $quote = $this->getMotivationalQuote();

        return view('dashboard', compact(
            'streak',
            'todayJournal',
            'weeklyMoods',
            'monthlyStats',
            'recentJournals',
            'quote',
            'moods',
            'todayMood',
        ));
    }

    private function getMotivationalQuote(): array
    {
        try {
            $response = Http::timeout(3)->get('https://zenquotes.io/api/today');
            if ($response->ok()) {
                $data = $response->json()[0];
                return ['text' => $data['q'], 'author' => $data['a']];
            }
        } catch (\Exception $e) {
            // Fallback kalau API down
        }

        $fallbacks = [
            ['text' => 'Setiap hari adalah kesempatan baru untuk menjadi lebih baik.', 'author' => 'MindLog'],
            ['text' => 'Menuliskan perasaan adalah langkah pertama menuju kesehatan mental yang baik.', 'author' => 'MindLog'],
            ['text' => 'Konsistensi kecil setiap hari menghasilkan perubahan besar.', 'author' => 'MindLog'],
        ];

        return $fallbacks[array_rand($fallbacks)];
    }
}
