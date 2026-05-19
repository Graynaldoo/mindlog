<?php

namespace App\Repositories;

use App\Models\Journal;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface JournalRepositoryInterface
{
    public function getAllByUser(int $userId, int $perPage = 10): LengthAwarePaginator;
    public function findById(int $id): ?Journal;
    public function create(array $data): Journal;
    public function update(Journal $journal, array $data): Journal;
    public function delete(Journal $journal): bool;
    public function getWeeklyMoodStats(int $userId): Collection;
    public function getMonthlyStats(int $userId): array;
    public function getTodayJournal(int $userId): ?Journal;
}
