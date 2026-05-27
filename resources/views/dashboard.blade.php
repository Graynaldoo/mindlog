@extends('layouts.app')

@section('title', 'Dashboard - MindLog EduSmart')

@section('content')
<div class="space-y-6">
    <section class="rounded-lg border border-slate-200 bg-white p-6 card-shadow">
        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <div>
                <p class="text-sm font-extrabold uppercase tracking-wide text-emerald-700">Pemanfaatan TIK untuk SDGs</p>
                <h1 class="mt-2 text-3xl font-extrabold text-slate-950">Halo, {{ auth()->user()->name }}</h1>
                <p class="mt-2 max-w-3xl text-sm font-medium leading-6 text-slate-600">
                    MindLog EduSmart membantu masyarakat menulis jurnal belajar, membaca artikel edukasi, membangun literasi digital, dan melihat dampak perkembangan dari data aktivitas.
                </p>
            </div>
            <a href="{{ route('articles.index') }}" class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-extrabold text-emerald-700 hover:bg-emerald-100">
                Baca Artikel Edukasi
            </a>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <x-dashboard-card title="Jurnal Mingguan" :value="$userStats['weekly_journals']" description="Jumlah refleksi belajar minggu ini" />
        <x-dashboard-card title="Artikel Dibaca" :value="$userStats['articles_read']" description="Akumulasi 30 hari terakhir" />
        <x-dashboard-card title="Durasi Belajar" value="{{ $userStats['learning_minutes'] }} menit" description="Dihitung dari aktivitas artikel" />
        <x-dashboard-card title="Peningkatan Aktivitas" value="{{ $userStats['activity_growth'] }}%" :description="$userStats['report']" />
    </section>

    <section class="grid gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2 rounded-lg border border-slate-200 bg-white p-6 card-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-extrabold">Dashboard Dampak Penggunaan</h2>
                    <p class="mt-1 text-sm font-medium text-slate-500">{{ $impactStats['report'] }}</p>
                </div>
                <span class="rounded-md bg-emerald-50 px-3 py-1 text-xs font-extrabold text-emerald-700">Chart.js</span>
            </div>
            <div class="mt-6 h-72">
                <canvas id="impactChart"></canvas>
            </div>
        </div>

        <div class="space-y-4">
            <x-statistics-card label="Total User" :value="$impactStats['users']" />
            <x-statistics-card label="Total Jurnal" :value="$impactStats['journals']" />
            <x-statistics-card label="Artikel Terbit" :value="$impactStats['published_articles']" />
            <x-statistics-card label="Menit Belajar Komunitas" :value="$impactStats['learning_minutes']" :trend="$impactStats['activity_growth']" />
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-3">
        <div class="rounded-lg border border-slate-200 bg-white p-6 card-shadow">
            <h2 class="text-lg font-extrabold">Mood dan Jurnal Hari Ini</h2>
            <p class="mt-1 text-sm font-medium text-slate-500">Catat kondisi belajar dan bangun kebiasaan refleksi.</p>
            <div class="mt-5 grid grid-cols-5 gap-2">
                @foreach($moods as $mood)
                    <form method="POST" action="{{ route('mood.set') }}">
                        @csrf
                        <input type="hidden" name="mood_id" value="{{ $mood->id }}">
                        <button class="w-full rounded-lg border px-2 py-3 text-center text-xs font-bold {{ $todayMood?->id === $mood->id ? 'border-emerald-500 bg-emerald-50 text-emerald-700' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                            <span class="block text-base">{{ $mood->emoji }}</span>
                            {{ $mood->name }}
                        </button>
                    </form>
                @endforeach
            </div>
            <a href="{{ route('journal.create') }}" class="mt-5 inline-flex rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-700">Tulis Jurnal Lengkap</a>
        </div>

        <div class="xl:col-span-2 rounded-lg border border-slate-200 bg-white p-6 card-shadow">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-extrabold">Artikel Edukasi Terbaru</h2>
                <a href="{{ route('articles.index') }}" class="text-sm font-extrabold text-emerald-700">Lihat semua</a>
            </div>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                @forelse($latestArticles as $article)
                    <a href="{{ route('articles.show', $article->slug) }}" class="rounded-lg border border-slate-200 p-4 hover:border-emerald-300 hover:bg-emerald-50/40">
                        <p class="text-xs font-extrabold uppercase tracking-wide text-emerald-700">{{ $article->category->name }}</p>
                        <h3 class="mt-2 text-base font-extrabold text-slate-950">{{ $article->title }}</h3>
                        <p class="mt-2 line-clamp-2 text-sm font-medium text-slate-600">{{ $article->excerpt }}</p>
                        <p class="mt-3 text-xs font-bold text-slate-500">{{ $article->estimated_minutes }} menit baca</p>
                    </a>
                @empty
                    <p class="text-sm font-semibold text-slate-500">Belum ada artikel terbit.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="rounded-lg border border-slate-200 bg-white p-6 card-shadow">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-extrabold">Kategori Pembelajaran</h2>
            @can('manage-categories')
                <a href="{{ route('categories.index') }}" class="text-sm font-extrabold text-emerald-700">Kelola kategori</a>
            @endcan
        </div>
        <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach($categories as $category)
                <div class="rounded-lg border border-slate-200 p-4">
                    <p class="text-base font-extrabold">{{ $category->name }}</p>
                    <p class="mt-2 text-sm font-medium text-slate-600">{{ $category->description }}</p>
                    <p class="mt-3 text-xs font-extrabold text-slate-500">{{ $category->sdg_focus }} - {{ $category->articles_count }} artikel</p>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const daily = @json($userStats['daily_chart']);
    const ctx = document.getElementById('impactChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: daily.map(item => item.date),
            datasets: [
                { label: 'Jurnal', data: daily.map(item => item.journals), backgroundColor: '#059669' },
                { label: 'Artikel', data: daily.map(item => item.articles), backgroundColor: '#2563eb' },
                { label: 'Menit Belajar', data: daily.map(item => item.minutes), backgroundColor: '#f59e0b', yAxisID: 'minutes' }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } },
                minutes: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } }
            }
        }
    });
});
</script>
@endpush
