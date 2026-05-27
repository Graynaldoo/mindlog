<?php

namespace App\Interfaces;

use App\Models\Statistic;

interface StatisticsRepositoryInterface
{
    public function recordJournal(int $userId): Statistic;

    public function recordArticleRead(int $userId, int $minutes = 5): Statistic;

    public function userSummary(int $userId): array;

    public function impactDashboard(): array;
}
