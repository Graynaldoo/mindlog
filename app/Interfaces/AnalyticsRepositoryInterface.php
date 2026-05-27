<?php

namespace App\Interfaces;

use App\Models\ImpactMetric;

interface AnalyticsRepositoryInterface
{
    public function statistics(?int $userId = null): array;

    public function impact(): array;

    public function leaderboard(): array;

    public function recalculateImpactMetric(): ImpactMetric;
}
