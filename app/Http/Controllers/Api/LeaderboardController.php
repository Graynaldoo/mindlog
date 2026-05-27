<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\AnalyticsRepositoryInterface;

class LeaderboardController extends Controller
{
    public function __construct(private AnalyticsRepositoryInterface $analytics) {}

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => $this->analytics->leaderboard(),
        ]);
    }
}
