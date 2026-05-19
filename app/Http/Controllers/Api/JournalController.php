<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\JournalRepository;
use App\Repositories\StreakRepository;
use App\Models\Mood;

class JournalController extends Controller
{
    public function __construct(
        private JournalRepository $journalRepo,
        private StreakRepository  $streakRepo,
    ) {}

    /**
     * GET /api/journals
     * Semua jurnal milik user yang login
     */
    public function index(Request $request)
    {
        $perPage  = $request->query('per_page', 10);
        $journals = $this->journalRepo->getAllByUser(auth()->id(), $perPage);

        return response()->json([
            'success' => true,
            'data'    => $journals,
        ]);
    }

    /**
     * POST /api/journals
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'mood_id'      => 'required|exists:moods,id',
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'journal_date' => 'required|date',
            'is_private'   => 'boolean',
        ]);

        $data['user_id'] = auth()->id();

        $journal = $this->journalRepo->create($data);

        // Update streak
        $this->streakRepo->updateStreak(auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Jurnal berhasil disimpan!',
            'data'    => $journal->load('mood'),
        ], 201);
    }

    /**
     * GET /api/journals/{id}
     */
    public function show(int $id)
    {
        $journal = $this->journalRepo->findById($id);

        if (!$journal || $journal->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Jurnal tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $journal,
        ]);
    }

    /**
     * PUT /api/journals/{id}
     */
    public function update(Request $request, int $id)
    {
        $journal = $this->journalRepo->findById($id);

        if (!$journal || $journal->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Jurnal tidak ditemukan.',
            ], 404);
        }

        $data = $request->validate([
            'mood_id'      => 'sometimes|exists:moods,id',
            'title'        => 'sometimes|string|max:255',
            'content'      => 'sometimes|string',
            'journal_date' => 'sometimes|date',
            'is_private'   => 'sometimes|boolean',
        ]);

        $journal = $this->journalRepo->update($journal, $data);

        return response()->json([
            'success' => true,
            'message' => 'Jurnal berhasil diperbarui!',
            'data'    => $journal,
        ]);
    }

    /**
     * DELETE /api/journals/{id}
     */
    public function destroy(int $id)
    {
        $journal = $this->journalRepo->findById($id);

        if (!$journal || $journal->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Jurnal tidak ditemukan.',
            ], 404);
        }

        $this->journalRepo->delete($journal);

        return response()->json([
            'success' => true,
            'message' => 'Jurnal berhasil dihapus.',
        ]);
    }

    /**
     * GET /api/journals/stats/weekly
     * Data grafik mood 7 hari terakhir
     */
    public function weeklyStats()
    {
        $data = $this->journalRepo->getWeeklyMoodStats(auth()->id());

        $chart = $data->map(fn($j) => [
            'date'       => $j->journal_date->format('D, d M'),
            'mood'       => $j->mood->name,
            'emoji'      => $j->mood->emoji,
            'mood_score' => $j->mood->score,
            'color'      => $j->mood->color,
        ]);

        return response()->json([
            'success' => true,
            'data'    => $chart,
        ]);
    }

    /**
     * GET /api/journals/stats/monthly
     */
    public function monthlyStats()
    {
        $stats = $this->journalRepo->getMonthlyStats(auth()->id());

        return response()->json([
            'success' => true,
            'data'    => $stats,
        ]);
    }

    /**
     * GET /api/moods
     * Daftar mood yang tersedia
     */
    public function moods()
    {
        return response()->json([
            'success' => true,
            'data'    => Mood::all(),
        ]);
    }
}
