<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\JournalRepositoryInterface;
use App\Interfaces\StatisticsRepositoryInterface;
use App\Models\Mood;
use App\Repositories\StreakRepository;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Journal", description="CRUD jurnal pribadi")
 */
class JournalController extends Controller
{
    public function __construct(
        private JournalRepositoryInterface $journalRepo,
        private StreakRepository $streakRepo,
        private StatisticsRepositoryInterface $statisticsRepo,
    ) {}

    /**
     * @OA\Get(path="/api/journals", tags={"Journal"}, summary="Daftar jurnal user", security={{"bearerAuth":{}}}, @OA\Response(response=200, description="Berhasil"))
     */
    public function index(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $this->journalRepo->getAllByUser(auth()->id(), (int) $request->query('per_page', 10)),
        ]);
    }

    /**
     * @OA\Post(path="/api/journals", tags={"Journal"}, summary="Tambah jurnal", security={{"bearerAuth":{}}}, @OA\Response(response=201, description="Jurnal dibuat"))
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'mood_id' => 'required|exists:moods,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'journal_date' => 'required|date',
            'is_private' => 'boolean',
        ]);

        $data['user_id'] = auth()->id();
        $journal = $this->journalRepo->create($data);

        $this->streakRepo->updateStreak(auth()->id());
        $this->statisticsRepo->recordJournal(auth()->id());

        return response()->json([
            'success' => true,
            'message' => 'Jurnal berhasil disimpan.',
            'data' => $journal->load('mood'),
        ], 201);
    }

    public function show(int $id)
    {
        $journal = $this->journalRepo->findById($id);

        if (!$journal || auth()->user()->cannot('view', $journal)) {
            return response()->json(['success' => false, 'message' => 'Jurnal tidak ditemukan.'], 404);
        }

        return response()->json(['success' => true, 'data' => $journal]);
    }

    public function update(Request $request, int $id)
    {
        $journal = $this->journalRepo->findById($id);

        if (!$journal || auth()->user()->cannot('update', $journal)) {
            return response()->json(['success' => false, 'message' => 'Jurnal tidak ditemukan.'], 404);
        }

        $data = $request->validate([
            'mood_id' => 'sometimes|exists:moods,id',
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'journal_date' => 'sometimes|date',
            'is_private' => 'sometimes|boolean',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jurnal berhasil diperbarui.',
            'data' => $this->journalRepo->update($journal, $data),
        ]);
    }

    public function destroy(int $id)
    {
        $journal = $this->journalRepo->findById($id);

        if (!$journal || auth()->user()->cannot('delete', $journal)) {
            return response()->json(['success' => false, 'message' => 'Jurnal tidak ditemukan.'], 404);
        }

        $this->journalRepo->delete($journal);

        return response()->json(['success' => true, 'message' => 'Jurnal berhasil dihapus.']);
    }

    public function weeklyStats()
    {
        $data = $this->journalRepo->getWeeklyMoodStats(auth()->id());

        return response()->json([
            'success' => true,
            'data' => $data->map(fn ($journal) => [
                'date' => $journal->journal_date->format('D, d M'),
                'mood' => $journal->mood->name,
                'mood_score' => $journal->mood->score,
                'color' => $journal->mood->color,
            ]),
        ]);
    }

    public function monthlyStats()
    {
        return response()->json([
            'success' => true,
            'data' => $this->journalRepo->getMonthlyStats(auth()->id()),
        ]);
    }

    public function moods()
    {
        return response()->json(['success' => true, 'data' => Mood::all()]);
    }
}
