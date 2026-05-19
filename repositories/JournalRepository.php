<?php

namespace App\Repositories;

use App\Models\Journal;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class JournalRepository implements JournalRepositoryInterface
{
    public function getAllByUser(int $userId, int $perPage = 10): LengthAwarePaginator
    {
        return Journal::with('mood')
            ->where('user_id', $userId)
            ->orderBy('journal_date', 'desc')
            ->paginate($perPage);
    }

    public function findById(int $id): ?Journal
    {
        return Journal::with('mood', 'user')->find($id);
    }

    public function create(array $data): Journal
    {
        return Journal::create($data);
    }

    public function update(Journal $journal, array $data): Journal
    {
        $journal->update($data);
        return $journal->fresh('mood');
    }

    public function delete(Journal $journal): bool
    {
        return $journal->delete();
    }

    /**
     * Ambil mood 7 hari terakhir untuk grafik
     */
    public function getWeeklyMoodStats(int $userId): Collection
    {
        return Journal::with('mood')
            ->where('user_id', $userId)
            ->whereBetween('journal_date', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay(),
            ])
            ->orderBy('journal_date', 'asc')
            ->get();
    }

    /**
     * Statistik bulan ini: total jurnal, rata-rata mood score
     */
    public function getMonthlyStats(int $userId): array
    {
        $journals = Journal::with('mood')
            ->where('user_id', $userId)
            ->thisMonth()
            ->get();

        $totalJournals  = $journals->count();
        $avgMoodScore   = $journals->avg(fn($j) => $j->mood->score ?? 0);
        $moodDistrib    = $journals->groupBy('mood_id')
            ->map(fn($group) => [
                'mood'  => $group->first()->mood,
                'count' => $group->count(),
            ])->values();

        return [
            'total_journals'  => $totalJournals,
            'avg_mood_score'  => round($avgMoodScore, 1),
            'mood_distribution' => $moodDistrib,
        ];
    }

    public function getTodayJournal(int $userId): ?Journal
    {
        return Journal::with('mood')
            ->where('user_id', $userId)
            ->whereDate('journal_date', today())
            ->first();
    }
}
