<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\StatisticsRepositoryInterface;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Statistics", description="Statistik perkembangan pengguna")
 */
class StatisticController extends Controller
{
    public function __construct(private StatisticsRepositoryInterface $statistics) {}

    /**
     * @OA\Get(path="/api/statistics", tags={"Statistics"}, summary="Statistik pengguna", security={{"bearerAuth":{}}}, @OA\Response(response=200, description="Berhasil"))
     */
    public function user()
    {
        return response()->json([
            'success' => true,
            'data' => $this->statistics->userSummary(auth()->id()),
        ]);
    }
}
