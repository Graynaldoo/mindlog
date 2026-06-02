@extends('layouts.app')

@section('title', 'Dashboard - MindLog EduSmart')

@section('content')
<div class="space-y-6 max-w-6xl">

    {{-- ═══ Hero Banner ═══════════════════════════════════ --}}
    <section class="hero-gradient p-6 md:p-8 text-white animate-fade-in" id="dashboard-hero">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex-1">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/10 mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse-soft"></span>
                    <span class="text-[11px] font-semibold tracking-wide text-indigo-100">Pemanfaatan TIK untuk SDGs</span>
                </div>

                <h1 class="text-2xl md:text-3xl font-extrabold leading-tight">
                    Selamat datang, {{ auth()->user()->name }}! 👋
                </h1>
                <p class="mt-3 max-w-xl text-sm font-medium leading-relaxed text-indigo-100/90">
                    MindLog EduSmart membantu masyarakat menulis jurnal belajar, membaca artikel edukasi, membangun literasi digital, dan melihat dampak perkembangan dari data aktivitas.
                </p>

                <div class="flex flex-wrap gap-3 mt-5">
                    <a href="{{ route('journal.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-indigo-700 text-sm font-bold rounded-xl hover:bg-indigo-50 transition-all duration-200 shadow-lg shadow-indigo-900/20"
                       id="hero-write-journal-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                        Tulis Jurnal
                    </a>
                    <a href="{{ route('articles.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/10 backdrop-blur-sm text-white text-sm font-bold rounded-xl border border-white/20 hover:bg-white/20 transition-all duration-200"
                       id="hero-articles-btn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                        Baca Artikel
                    </a>
                </div>
            </div>

            {{-- Decorative Illustration --}}
            <div class="hidden lg:flex items-center justify-center flex-shrink-0">
                <div class="relative">
                    <div class="w-40 h-40 rounded-3xl bg-white/10 backdrop-blur-sm border border-white/10 flex items-center justify-center animate-float">
                        <svg class="w-20 h-20 text-white/80" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/>
                        </svg>
                    </div>
                    <div class="absolute -top-3 -right-3 w-8 h-8 rounded-xl bg-amber-400/90 flex items-center justify-center text-sm animate-pulse-soft shadow-lg">🎯</div>
                    <div class="absolute -bottom-2 -left-4 w-10 h-10 rounded-xl bg-emerald-400/90 flex items-center justify-center text-lg shadow-lg">📚</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ Statistics Cards ═══════════════════════════════ --}}
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4 stagger-children" id="dashboard-stats">
        <x-dashboard-card
            title="Jurnal Mingguan"
            :value="$userStats['weekly_journals']"
            description="Jumlah refleksi belajar minggu ini"
            color="indigo"
            icon='<svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>'
        />
        <x-dashboard-card
            title="Artikel Dibaca"
            :value="$userStats['articles_read']"
            description="Akumulasi 30 hari terakhir"
            color="emerald"
            icon='<svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>'
        />
        <x-dashboard-card
            title="Durasi Belajar"
            value="{{ $userStats['learning_minutes'] }} menit"
            description="Dihitung dari aktivitas artikel"
            color="amber"
            icon='<svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        />
        <x-dashboard-card
            title="Peningkatan"
            value="{{ $userStats['activity_growth'] }}%"
            :description="$userStats['report']"
            color="violet"
            icon='<svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/></svg>'
        />
    </section>

    {{-- ═══ Chart + Impact Stats ══════════════════════════ --}}
    <section class="grid gap-6 xl:grid-cols-3" id="dashboard-chart-section">
        {{-- Activity Chart --}}
        <div class="xl:col-span-2 card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Dashboard Dampak Penggunaan</h2>
                    <p class="mt-1 text-xs font-medium text-slate-400">{{ $impactStats['report'] }}</p>
                </div>
                <div class="badge-primary">Aktivitas 7 Hari</div>
            </div>
            <div class="h-72">
                <canvas id="impactChart"></canvas>
            </div>
        </div>

        {{-- Impact Quick Stats --}}
        <div class="space-y-3 stagger-children">
            <x-statistics-card label="Total User" :value="$impactStats['users']" />
            <x-statistics-card label="Total Jurnal" :value="$impactStats['journals']" />
            <x-statistics-card label="Artikel Terbit" :value="$impactStats['published_articles']" />
            <x-statistics-card label="Menit Belajar" :value="$impactStats['learning_minutes']" :trend="$impactStats['activity_growth']" />
        </div>
    </section>

    {{-- ═══ Mood + Streak + Articles ═════════════════════ --}}
    <section class="grid gap-6 xl:grid-cols-3" id="dashboard-mood-section">

        {{-- Mood & Journal Today --}}
        <div class="card p-6">
            <div class="flex items-center gap-3 mb-5">
                <div class="w-9 h-9 rounded-xl bg-violet-50 ring-1 ring-violet-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Mood Hari Ini</h2>
                    <p class="text-[11px] font-medium text-slate-400">Catat kondisi belajarmu</p>
                </div>
            </div>

            <div class="grid grid-cols-5 gap-2 mb-5">
                @foreach($moods as $mood)
                    <form method="POST" action="{{ route('mood.set') }}">
                        @csrf
                        <input type="hidden" name="mood_id" value="{{ $mood->id }}">
                        <button class="w-full rounded-[1.25rem] border px-1 py-4 text-center transition-all duration-200 hover:-translate-y-0.5 flex flex-col items-center justify-center gap-2 h-24
                            {{ $todayMood?->id === $mood->id
                                ? 'border-indigo-300 bg-indigo-50 ring-2 ring-indigo-100 shadow-sm'
                                : 'border-slate-200 hover:bg-slate-50 hover:border-slate-300' }}"
                            id="mood-btn-{{ $mood->id }}">
                            <x-mood-icon :score="$mood->score" class="w-10 h-10" />
                            <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-wider leading-tight px-1">{{ $mood->name }}</span>
                        </button>
                    </form>
                @endforeach
            </div>

            <a href="{{ route('journal.create') }}"
               class="btn btn-primary w-full" id="dashboard-write-journal-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                </svg>
                Tulis Jurnal Lengkap
            </a>
        </div>

        {{-- Latest Articles --}}
        <div class="xl:col-span-2 card p-6">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 ring-1 ring-emerald-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                        </svg>
                    </div>
                    <h2 class="text-base font-extrabold text-slate-900">Artikel Edukasi Terbaru</h2>
                </div>
                <a href="{{ route('articles.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition-colors" id="view-all-articles-link">
                    Lihat semua →
                </a>
            </div>

            <div class="grid gap-3 md:grid-cols-2">
                @forelse($latestArticles as $article)
                    <a href="{{ route('articles.show', $article->slug) }}"
                       class="group flex flex-col justify-between p-4 rounded-xl border border-slate-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all duration-200"
                       id="article-card-{{ $article->slug }}">
                        <div>
                            <div class="badge-primary mb-2.5 inline-block">{{ $article->category->name }}</div>
                            <h3 class="text-sm font-bold text-slate-800 group-hover:text-indigo-700 transition-colors leading-snug">{{ $article->title }}</h3>
                            <p class="mt-1.5 text-xs font-medium text-slate-400 line-clamp-2 leading-relaxed">{{ $article->excerpt }}</p>
                        </div>
                        <p class="mt-3 text-[11px] font-semibold text-slate-400">{{ $article->estimated_minutes }} menit baca</p>
                    </a>
                @empty
                    <div class="col-span-2 text-center py-8">
                        <p class="text-sm font-medium text-slate-400">Belum ada artikel terbit.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══ Learning Categories ═══════════════════════════ --}}
    <section class="card p-6" id="dashboard-categories">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 ring-1 ring-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/>
                    </svg>
                </div>
                <h2 class="text-base font-extrabold text-slate-900">Kategori Pembelajaran</h2>
            </div>
            @can('manage-categories')
                <a href="{{ route('categories.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition-colors" id="manage-categories-link">
                    Kelola →
                </a>
            @endcan
        </div>

        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3 stagger-children">
            @foreach($categories as $category)
                <div class="group p-4 rounded-xl border border-slate-100 hover:border-indigo-200 hover:bg-indigo-50/20 transition-all duration-200" id="category-{{ Str::slug($category->name) }}">
                    <p class="text-sm font-bold text-slate-800 group-hover:text-indigo-700 transition-colors">{{ $category->name }}</p>
                    <p class="mt-1.5 text-xs font-medium text-slate-400 leading-relaxed line-clamp-2">{{ $category->description }}</p>
                    <div class="mt-3 flex items-center gap-2">
                        <span class="badge-primary">{{ $category->sdg_focus }}</span>
                        <span class="text-[11px] font-semibold text-slate-400">{{ $category->articles_count }} artikel</span>
                    </div>
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

    const gradient1 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 280);
    gradient1.addColorStop(0, 'rgba(99, 102, 241, 0.15)');
    gradient1.addColorStop(1, 'rgba(99, 102, 241, 0.01)');

    const gradient2 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 280);
    gradient2.addColorStop(0, 'rgba(16, 185, 129, 0.15)');
    gradient2.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: daily.map(item => item.date),
            datasets: [
                {
                    label: 'Jurnal',
                    data: daily.map(item => item.journals),
                    backgroundColor: 'rgba(99, 102, 241, 0.85)',
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.6,
                },
                {
                    label: 'Artikel',
                    data: daily.map(item => item.articles),
                    backgroundColor: 'rgba(16, 185, 129, 0.85)',
                    borderRadius: 6,
                    borderSkipped: false,
                    barPercentage: 0.6,
                },
                {
                    label: 'Menit Belajar',
                    data: daily.map(item => item.minutes),
                    type: 'line',
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.08)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#f59e0b',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    yAxisID: 'minutes',
                    borderWidth: 2.5,
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
                        padding: 16,
                        font: { size: 11, weight: '600', family: "'Plus Jakarta Sans'" },
                        color: '#64748b',
                    },
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { size: 12, weight: '700', family: "'Plus Jakarta Sans'" },
                    bodyFont: { size: 11, weight: '500', family: "'Plus Jakarta Sans'" },
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: true,
                    usePointStyle: true,
                },
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11, weight: '600', family: "'Plus Jakarta Sans'" }, color: '#94a3b8' },
                    border: { display: false },
                },
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0, font: { size: 11, family: "'Plus Jakarta Sans'" }, color: '#94a3b8', padding: 8 },
                    grid: { color: 'rgba(226, 232, 240, 0.6)', drawBorder: false },
                    border: { display: false },
                },
                minutes: {
                    beginAtZero: true,
                    position: 'right',
                    ticks: { font: { size: 11, family: "'Plus Jakarta Sans'" }, color: '#94a3b8', padding: 8 },
                    grid: { drawOnChartArea: false },
                    border: { display: false },
                }
            }
        }
    });
});
</script>
@endpush
