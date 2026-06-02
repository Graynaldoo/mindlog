@extends('layouts.app')
@section('title', 'Statistik & Pencapaian - MindLog EduSmart')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto animate-fade-in">
    {{-- Header --}}
    <div class="card p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 border border-emerald-100 mb-3">
                <span class="text-[11px] font-bold tracking-wide text-emerald-700 uppercase">Analisis Aktivitas</span>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Statistik Perkembangan</h1>
            <p class="text-sm font-medium text-slate-500 mt-2 max-w-2xl leading-relaxed">
                {{ $userStats['report'] }}
            </p>
        </div>
        <div class="flex-shrink-0 text-center md:text-right">
            <div class="min-w-[4rem] px-4 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white inline-flex items-center justify-center text-2xl font-extrabold shadow-lg shadow-indigo-200 mx-auto md:ml-auto md:mr-0 mb-2">
                {{ $userStats['activity_growth'] }}%
            </div>
            <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Growth Rate</span>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4 stagger-children">
        <x-dashboard-card
            title="Jurnal Mingguan"
            :value="$userStats['weekly_journals']"
            description="Refleksi 7 hari terakhir"
            color="indigo"
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>'
        />
        <x-dashboard-card
            title="Artikel Dibaca"
            :value="$userStats['articles_read']"
            description="Total bacaan edukatif"
            color="emerald"
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>'
        />
        <x-dashboard-card
            title="Durasi Belajar"
            value="{{ $userStats['learning_minutes'] }} mnt"
            description="Estimasi waktu belajar"
            color="amber"
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        />
        <x-dashboard-card
            title="Aktivitas"
            value="+{{ $userStats['activity_growth'] }}%"
            description="Dibanding bulan lalu"
            color="violet"
            icon='<svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>'
        />
    </div>

    {{-- Detailed Chart --}}
    <div class="card p-6 md:p-8 bg-white">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900">Grafik Aktivitas Harian</h2>
                <p class="text-xs font-medium text-slate-500 mt-1">Tren menulis jurnal dan membaca artikel dalam sebulan terakhir.</p>
            </div>
            <div class="badge-primary">30 Hari Terakhir</div>
        </div>
        <div class="h-96">
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
    const ctx = document.getElementById('userStatsChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: daily.map(item => item.date),
            datasets: [
                {
                    label: 'Jurnal',
                    data: daily.map(item => item.journals),
                    borderColor: '#4f46e5', // indigo-600
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointBackgroundColor: '#4f46e5',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
                {
                    label: 'Artikel',
                    data: daily.map(item => item.articles),
                    borderColor: '#10b981', // emerald-500
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                },
                {
                    label: 'Menit Belajar',
                    data: daily.map(item => item.minutes),
                    borderColor: '#f59e0b', // amber-500
                    borderDash: [5, 5],
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    borderWidth: 2,
                    pointBackgroundColor: '#f59e0b',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    yAxisID: 'minutes',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: { size: 12, weight: '600', family: "'Plus Jakarta Sans'" },
                        color: '#64748b',
                    },
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                    titleFont: { size: 13, weight: '700', family: "'Plus Jakarta Sans'" },
                    bodyFont: { size: 12, weight: '500', family: "'Plus Jakarta Sans'" },
                    padding: 16,
                    cornerRadius: 12,
                    displayColors: true,
                    usePointStyle: true,
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11, weight: '600', family: "'Plus Jakarta Sans'" }, color: '#94a3b8', maxTicksLimit: 10 },
                    border: { display: false },
                },
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, font: { size: 11, family: "'Plus Jakarta Sans'" }, color: '#94a3b8', padding: 10 },
                    grid: { color: 'rgba(226, 232, 240, 0.5)', drawBorder: false },
                    border: { display: false },
                },
                minutes: {
                    beginAtZero: true,
                    position: 'right',
                    ticks: { font: { size: 11, family: "'Plus Jakarta Sans'" }, color: '#94a3b8', padding: 10 },
                    grid: { drawOnChartArea: false },
                    border: { display: false },
                }
            }
        }
    });
});
</script>
@endpush
