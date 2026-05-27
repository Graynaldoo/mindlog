<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Interfaces\JournalRepositoryInterface;
use App\Interfaces\StatisticsRepositoryInterface;
use App\Models\Journal;
use App\Models\Mood;
use App\Repositories\StreakRepository;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function __construct(
        private JournalRepositoryInterface $journalRepo,
        private StreakRepository $streakRepo,
        private StatisticsRepositoryInterface $statisticsRepo,
    ) {}

    public function index()
    {
        return view('journal.index', [
            'journals' => $this->journalRepo->getAllByUser(auth()->id(), 9),
        ]);
    }

    public function create()
    {
        return view('journal.create', ['moods' => Mood::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mood_id' => 'required|exists:moods,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'daily_activities' => 'nullable|string',
            'productivity_score' => 'nullable|integer|min:0|max:100',
            'activity_minutes' => 'nullable|integer|min:0|max:1440',
            'journal_date' => 'required|date',
            'is_private' => 'boolean',
        ]);

        $data['user_id'] = auth()->id();
        $data['is_private'] = $request->boolean('is_private', true);

        $this->journalRepo->create($data);
        $this->streakRepo->updateStreak(auth()->id());
        $this->statisticsRepo->recordJournal(auth()->id());

        return redirect()->route('journal.index')->with('success', 'Jurnal berhasil disimpan.');
    }

    public function show(Journal $journal)
    {
        $this->authorize('view', $journal);

        return view('journal.show', compact('journal'));
    }

    public function edit(Journal $journal)
    {
        $this->authorize('update', $journal);

        return view('journal.edit', [
            'journal' => $journal,
            'moods' => Mood::all(),
        ]);
    }

    public function update(Request $request, Journal $journal)
    {
        $this->authorize('update', $journal);

        $data = $request->validate([
            'mood_id' => 'required|exists:moods,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'daily_activities' => 'nullable|string',
            'productivity_score' => 'nullable|integer|min:0|max:100',
            'activity_minutes' => 'nullable|integer|min:0|max:1440',
            'journal_date' => 'required|date',
        ]);

        $data['is_private'] = $request->boolean('is_private');
        $this->journalRepo->update($journal, $data);

        return redirect()->route('journal.show', $journal)->with('success', 'Jurnal berhasil diperbarui.');
    }

    public function setMood(Request $request)
    {
        $request->validate(['mood_id' => 'required|exists:moods,id']);

        $userId = auth()->id();
        $todayJournal = $this->journalRepo->getTodayJournal($userId);

        if ($todayJournal) {
            $this->journalRepo->update($todayJournal, ['mood_id' => $request->mood_id]);
        } else {
            $mood = Mood::findOrFail($request->mood_id);
            $this->journalRepo->create([
                'user_id' => $userId,
                'mood_id' => $mood->id,
                'title' => 'Mood Hari Ini',
                'content' => 'Saya merasa ' . $mood->name . ' hari ini.',
                'journal_date' => today(),
                'is_private' => true,
            ]);
            $this->streakRepo->updateStreak($userId);
            $this->statisticsRepo->recordJournal($userId);
        }

        return redirect()->back()->with('success', 'Mood hari ini berhasil diperbarui.');
    }

    public function destroy(Journal $journal)
    {
        $this->authorize('delete', $journal);
        $this->journalRepo->delete($journal);

        return redirect()->route('journal.index')->with('success', 'Jurnal berhasil dihapus.');
    }
}
