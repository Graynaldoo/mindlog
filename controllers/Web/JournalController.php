<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\JournalRepository;
use App\Repositories\StreakRepository;
use App\Models\Mood;
use App\Models\Journal;

class JournalController extends Controller
{
    public function __construct(
        private JournalRepository $journalRepo,
        private StreakRepository  $streakRepo,
    ) {}

    public function index()
    {
        $journals = $this->journalRepo->getAllByUser(auth()->id(), 9);
        return view('journal.index', compact('journals'));
    }

    public function create()
    {
        $moods = Mood::all();
        return view('journal.create', compact('moods'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mood_id'      => 'required|exists:moods,id',
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'journal_date' => 'required|date',
            'is_private'   => 'boolean',
        ]);

        $data['user_id']   = auth()->id();
        $data['is_private'] = $request->has('is_private');

        $this->journalRepo->create($data);
        $this->streakRepo->updateStreak(auth()->id());

        return redirect()->route('journal.index')
            ->with('success', 'Jurnal berhasil disimpan! 🎉');
    }

    public function show(Journal $journal)
    {
        abort_if($journal->user_id !== auth()->id(), 403);
        return view('journal.show', compact('journal'));
    }

    public function edit(Journal $journal)
    {
        abort_if($journal->user_id !== auth()->id(), 403);
        $moods = Mood::all();
        return view('journal.edit', compact('journal', 'moods'));
    }

    public function update(Request $request, Journal $journal)
    {
        abort_if($journal->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'mood_id'      => 'required|exists:moods,id',
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'journal_date' => 'required|date',
        ]);

        $data['is_private'] = $request->has('is_private');
        $this->journalRepo->update($journal, $data);

        return redirect()->route('journal.show', $journal)
            ->with('success', 'Jurnal berhasil diperbarui!');
    }

    public function destroy(Journal $journal)
    {
        abort_if($journal->user_id !== auth()->id(), 403);
        $this->journalRepo->delete($journal);

        return redirect()->route('journal.index')
            ->with('success', 'Jurnal berhasil dihapus.');
    }
}
