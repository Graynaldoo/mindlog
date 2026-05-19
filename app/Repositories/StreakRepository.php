<?php

namespace App\Repositories;

use App\Models\Streak;
use App\Models\Journal;
use Carbon\Carbon;

class StreakRepository
{
    /**
     * Update streak setiap kali user menyimpan jurnal
     */
    public function updateStreak(int $userId): Streak
    {
        $streak = Streak::firstOrCreate(
            ['user_id' => $userId],
            ['current_streak' => 0, 'longest_streak' => 0]
        );

        $today     = Carbon::today();
        $lastDate  = $streak->last_journal_date
            ? Carbon::parse($streak->last_journal_date)
            : null;

        if ($lastDate === null) {
            // Jurnal pertama
            $streak->current_streak = 1;
        } elseif ($lastDate->isYesterday()) {
            // Lanjut streak
            $streak->current_streak += 1;
        } elseif ($lastDate->isToday()) {
            // Sudah nulis hari ini, tidak bertambah
            return $streak;
        } else {
            // Streak putus
            $streak->current_streak = 1;
        }

        if ($streak->current_streak > $streak->longest_streak) {
            $streak->longest_streak = $streak->current_streak;
        }

        $streak->last_journal_date = $today;
        $streak->save();

        return $streak;
    }

    public function getByUser(int $userId): ?Streak
    {
        return Streak::where('user_id', $userId)->first();
    }
}
