<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\AnalyticsRepositoryInterface;

class AnalyticsController extends Controller
{
    public function __construct(private AnalyticsRepositoryInterface $analytics) {}

    public function statistics()
    {
        return response()->json([
            'success' => true,
            'data' => $this->analytics->statistics(auth()->id()),
        ]);
    }

    public function impact()
    {
        return response()->json([
            'success' => true,
            'data' => $this->analytics->impact(),
        ]);
    }
}
