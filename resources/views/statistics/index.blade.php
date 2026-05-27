@extends('layouts.app')

@section('title', 'Statistik - MindLog EduSmart')

@section('content')
<div class="space-y-6">
    <div class="rounded-lg border border-slate-200 bg-white p-6 card-shadow">
        <h1 class="text-2xl font-extrabold">Statistik Perkembangan Pengguna</h1>
        <p class="mt-2 text-sm font-medium text-slate-600">{{ $userStats['report'] }}. Data diambil dari tabel statistics, journals, dan articles.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <x-statistics-card label="Jurnal Mingguan" :value="$userStats['weekly_journals']" />
        <x-statistics-card label="Artikel Dibaca" :value="$userStats['articles_read']" />
        <x-statistics-card label="Durasi Belajar" value="{{ $userStats['learning_minutes'] }} menit" />
        <x-statistics-card label="Peningkatan" :value="$userStats['activity_growth'] . '%'" :trend="$userStats['activity_growth']" />
    </div>

    <div class="rounded-lg border border-slate-200 bg-white p-6 card-shadow">
        <h2 class="text-lg font-extrabold">Aktivitas Harian</h2>
        <div class="mt-5 h-80">
            <canvas id="userStatsChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const daily = @json($userStats['daily_chart']);
    new Chart(document.getElementById('userStatsChart'), {
        type: 'line',
        data: {
            labels: daily.map(item => item.date),
            datasets: [
                { label: 'Jurnal', data: daily.map(item => item.journals), borderColor: '#059669', backgroundColor: 'rgba(5,150,105,.1)', tension: .35 },
                { label: 'Artikel', data: daily.map(item => item.articles), borderColor: '#2563eb', backgroundColor: 'rgba(37,99,235,.1)', tension: .35 },
                { label: 'Menit Belajar', data: daily.map(item => item.minutes), borderColor: '#f59e0b', backgroundColor: 'rgba(245,158,11,.1)', tension: .35 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
});
</script>
@endpush
