@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
{{-- Header --}}
<div class="mb-8">
    <h1 class="font-display text-4xl text-gray-900">
        Selamat datang, {{ auth()->user()->name }} 👋
    </h1>
    <p class="mt-1 text-gray-500">
        {{ now()->translatedFormat('l, d F Y') }}
    </p>
</div>

{{-- Quote harian --}}
<div class="mb-8 bg-white rounded-2xl p-6 border border-gray-100 relative overflow-hidden">
    <div class="absolute top-0 left-0 w-1 h-full bg-violet-400 rounded-l-2xl"></div>
    <p class="font-display text-xl italic text-gray-700 pl-4">
        "{{ $quote['text'] }}"
    </p>
    <p class="text-sm text-gray-400 mt-2 pl-4">— {{ $quote['author'] }}</p>
</div>

{{-- Stats row --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
    {{-- Streak card --}}
    <x-streak-card :streak="$streak" />

    {{-- Total bulan ini --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm text-gray-500 font-medium">Bulan Ini</span>
            <span class="text-2xl">📝</span>
        </div>
        <div class="text-5xl font-display font-bold text-gray-900">
            {{ $monthlyStats['total_journals'] }}
        </div>
        <p class="text-sm text-gray-400 mt-2">entri jurnal</p>
    </div>

    {{-- Rata-rata mood --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <span class="text-sm text-gray-500 font-medium">Rata-rata Mood</span>
            <span class="text-2xl">✨</span>
        </div>
        <div class="text-5xl font-display font-bold text-gray-900">
            {{ $monthlyStats['avg_mood_score'] }}
            <span class="text-2xl text-gray-400">/5</span>
        </div>
        <p class="text-sm text-gray-400 mt-2">skor mood bulan ini</p>
    </div>
</div>

{{-- Jurnal hari ini --}}
@if($todayJournal)
    <div class="mb-8 bg-amber-50 border border-amber-100 rounded-2xl p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-amber-600 mb-1">✅ Jurnal hari ini sudah ditulis</p>
                <h3 class="font-semibold text-gray-900">{{ $todayJournal->title }}</h3>
            </div>
            <a href="{{ route('journal.show', $todayJournal) }}"
               class="text-sm text-amber-700 hover:text-amber-900 font-medium">
                Lihat →
            </a>
        </div>
    </div>
@else
    <div class="mb-8 bg-violet-50 border border-violet-100 rounded-2xl p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-violet-600 mb-1">💭 Belum nulis hari ini</p>
                <p class="text-gray-700 text-sm">Bagaimana perasaanmu hari ini?</p>
            </div>
            <a href="{{ route('journal.create') }}"
               class="px-4 py-2 bg-violet-600 hover:bg-violet-700 text-white text-sm font-medium rounded-xl transition-colors">
                Tulis Sekarang
            </a>
        </div>
    </div>
@endif

{{-- Grafik mood 7 hari --}}
<div class="mb-8 bg-white rounded-2xl p-6 border border-gray-100">
    <h2 class="font-semibold text-gray-900 mb-4">Mood 7 Hari Terakhir</h2>
    @if($weeklyMoods->count() > 0)
        <canvas id="moodChart" height="80"></canvas>
    @else
        <p class="text-gray-400 text-sm text-center py-8">Belum ada data mood minggu ini.</p>
    @endif
</div>

{{-- Jurnal terbaru --}}
<div>
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-semibold text-gray-900">Jurnal Terbaru</h2>
        <a href="{{ route('journal.index') }}" class="text-sm text-violet-600 hover:text-violet-800">
            Lihat semua →
        </a>
    </div>

    @if($recentJournals->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($recentJournals as $journal)
                <x-journal-card :journal="$journal" />
            @endforeach
        </div>
    @else
        <div class="text-center py-16 text-gray-400">
            <p class="text-4xl mb-3">📖</p>
            <p class="text-sm">Belum ada jurnal. Mulai tulis sekarang!</p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const weeklyData = @json($weeklyMoods->map(fn($j) => [
    'label' => $j->journal_date->format('D'),
    'score' => $j->mood->score,
    'emoji' => $j->mood->emoji,
    'color' => $j->mood->color,
]));

if (weeklyData.length > 0) {
    const ctx = document.getElementById('moodChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: weeklyData.map(d => d.label),
            datasets: [{
                label: 'Skor Mood',
                data: weeklyData.map(d => d.score),
                borderColor: '#7C3AED',
                backgroundColor: 'rgba(124,58,237,0.08)',
                borderWidth: 2,
                pointBackgroundColor: weeklyData.map(d => d.color),
                pointRadius: 6,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    min: 0, max: 5,
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: { stepSize: 1 }
                },
                x: { grid: { display: false } }
            }
        }
    });
}
</script>
@endpush
