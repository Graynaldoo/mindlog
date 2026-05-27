<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Interfaces\StatisticsRepositoryInterface;

class StatisticsController extends Controller
{
    public function __construct(private StatisticsRepositoryInterface $statistics) {}

    public function index()
    {
        return view('statistics.index', [
            'userStats' => $this->statistics->userSummary(auth()->id()),
            'impactStats' => $this->statistics->impactDashboard(),
        ]);
    }
}
