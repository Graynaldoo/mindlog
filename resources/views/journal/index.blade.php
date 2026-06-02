@extends('layouts.app')
@section('title', 'Jurnal Harian - MindLog EduSmart')

@section('content')
<div x-data="{ view: 'calendar' }" class="max-w-7xl mx-auto animate-fade-in space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Jurnal Harian</h1>
            <p class="text-sm text-slate-500 mt-1 max-w-sm leading-relaxed">
                Pantau perkembangan refleksi belajar Anda setiap harinya.
            </p>
        </div>

        {{-- Toggle Views --}}
        <div class="inline-flex bg-white rounded-xl border border-slate-200 p-1 shadow-sm">
            <button @click="view = 'calendar'" 
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold transition-colors"
                    :class="view === 'calendar' ? 'text-white shadow-md' : 'text-slate-500 hover:text-slate-800'"
                    :style="view === 'calendar' ? 'background-color: #4f46e5;' : ''">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                Kalender
            </button>
            <button @click="view = 'list'" 
                    class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-colors"
                    :class="view === 'list' ? 'text-white shadow-md' : 'text-slate-500 hover:text-slate-800'"
                    :style="view === 'list' ? 'background-color: #4f46e5;' : ''">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z" />
                </svg>
                Daftar
            </button>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 pt-2">
        
        {{-- Left Column (Calendar & Entries) --}}
        <div class="lg:col-span-8 space-y-8">
            
            {{-- Calendar Widget (Alpine.js Interactive) --}}
            <div x-show="view === 'calendar'" x-transition x-data="calendar()" class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600" style="color: #4f46e5;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5" /></svg>
                        </div>
                        <h2 class="text-xl font-bold text-slate-800" x-text="monthNames[month] + ' ' + year"></h2>
                    </div>
                    <div class="flex gap-2">
                        <button @click="prevMonth()" class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                        </button>
                        <button @click="nextMonth()" class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                        </button>
                    </div>
                </div>

                {{-- Kalender Grid --}}
                <div class="gap-y-6 text-center" style="display: grid; grid-template-columns: repeat(7, minmax(0, 1fr));">
                    {{-- Days Header --}}
                    <template x-for="day in ['MIN', 'SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB']">
                        <div class="text-[11px] font-bold text-slate-400 tracking-widest" x-text="day"></div>
                    </template>

                    {{-- Empty slots --}}
                    <template x-for="blank in blankDays">
                        <div></div>
                    </template>

                    {{-- Days --}}
                    <template x-for="day in daysInMonth" :key="day">
                        <div class="flex flex-col items-center justify-start py-1" style="min-height: 48px;">
                            <div @click="selectDate(day)" 
                                 class="flex flex-col items-center justify-center w-9 h-9 relative cursor-pointer rounded-xl transition-colors"
                                 :class="{ 'bg-indigo-50 hover:bg-indigo-100': isToday(day), 'hover:bg-slate-50': !isToday(day) }"
                                 :style="isToday(day) ? 'border: 2px solid #4f46e5;' : ''">
                                
                                <span class="text-sm font-bold" :class="isToday(day) ? 'text-indigo-600' : 'text-slate-700'" :style="isToday(day) ? 'color: #4f46e5;' : ''" x-text="day"></span>
                            </div>
                            <!-- Today indicator moved below to prevent overlap -->
                            <span x-show="isToday(day)" class="text-[9px] font-bold text-indigo-600 mt-0.5" style="color: #4f46e5;">Today</span>
                            
                            <!-- Journal dots based on real PHP data -->
                            <div x-show="hasJournal(day) && !isToday(day)" class="w-1.5 h-1.5 rounded-full bg-indigo-600 mt-1" style="background-color: #4f46e5;"></div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Recent Entries Section --}}
            <div x-show="view === 'calendar'" x-transition>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-slate-900">Entri Terbaru</h2>
                    <button @click="view = 'list'" class="text-sm font-semibold text-indigo-600 hover:text-indigo-700" style="color: #4f46e5;">Lihat Semua</button>
                </div>

                @if($journals->count() > 0)
                    <div class="space-y-4">
                        @foreach($journals->take(5) as $journal)
                            <a href="{{ route('journal.show', $journal) }}" class="bg-white rounded-2xl border border-slate-200 p-5 flex gap-4 hover:shadow-md transition-shadow block">
                                {{-- Date Circle --}}
                                <div class="w-12 h-12 rounded-full flex flex-col items-center justify-center flex-shrink-0" style="background-color: #eef2ff;">
                                    <span class="text-[9px] font-bold uppercase tracking-wider" style="color: #6366f1;">{{ $journal->journal_date->translatedFormat('M') }}</span>
                                    <span class="text-base font-extrabold leading-none" style="color: #4338ca;">{{ $journal->journal_date->format('d') }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-4 mb-2">
                                        <h3 class="text-base font-bold text-slate-900 truncate pt-1">{{ $journal->title }}</h3>
                                        <button class="text-slate-400 hover:text-slate-600 px-1 pt-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" /></svg>
                                        </button>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2 mb-3">
                                        {{-- Mood Badge --}}
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-600 flex items-center gap-1.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm3.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75z"/></svg>
                                            {{ $journal->mood->name ?? 'Refleksi' }}
                                        </span>
                                        {{-- Date Badge --}}
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-semibold text-emerald-600 flex items-center gap-1.5" style="background-color: #d1fae5;">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
                                            {{ $journal->journal_date->translatedFormat('l, d M Y') }}
                                        </span>
                                    </div>
                                    <p class="text-sm font-medium text-slate-500 leading-relaxed line-clamp-2">
                                        {{ strip_tags($journal->content) }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 bg-white rounded-2xl border border-slate-200 border-dashed">
                        <p class="text-sm font-medium text-slate-500">Belum ada jurnal yang ditulis.</p>
                    </div>
                @endif
            </div>
            
            {{-- List View Section (Daftar) --}}
            <div x-cloak x-show="view === 'list'" x-transition>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-slate-900">Semua Jurnal</h2>
                    <span class="text-sm font-medium text-slate-500">Menampilkan {{ $journals->count() }} entri</span>
                </div>

                @if($journals->count() > 0)
                    <div class="space-y-4">
                        @foreach($journals as $journal)
                            <a href="{{ route('journal.show', $journal) }}" class="bg-white rounded-2xl border border-slate-200 p-5 flex gap-4 hover:shadow-md transition-shadow block">
                                {{-- Date Circle --}}
                                <div class="w-12 h-12 rounded-full flex flex-col items-center justify-center flex-shrink-0" style="background-color: #eef2ff;">
                                    <span class="text-[9px] font-bold uppercase tracking-wider" style="color: #6366f1;">{{ $journal->journal_date->translatedFormat('M') }}</span>
                                    <span class="text-base font-extrabold leading-none" style="color: #4338ca;">{{ $journal->journal_date->format('d') }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-4 mb-2">
                                        <h3 class="text-base font-bold text-slate-900 truncate pt-1">{{ $journal->title }}</h3>
                                        <button class="text-slate-400 hover:text-slate-600 px-1 pt-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" /></svg>
                                        </button>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2 mb-3">
                                        <span class="px-2.5 py-1 rounded-md text-[10px] font-semibold bg-slate-100 text-slate-600 flex items-center gap-1.5">
                                            {{ $journal->mood->name ?? 'Refleksi' }}
                                        </span>
                                    </div>
                                    <p class="text-sm font-medium text-slate-500 leading-relaxed line-clamp-2">
                                        {{ strip_tags($journal->content) }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    {{-- Pagination --}}
                    @if($journals->hasPages())
                        <div class="mt-6">{{ $journals->links() }}</div>
                    @endif
                @else
                    <div class="text-center py-12 bg-white rounded-2xl border border-slate-200 border-dashed">
                        <p class="text-sm font-medium text-slate-500">Belum ada jurnal yang ditulis.</p>
                    </div>
                @endif
            </div>

        </div>

        {{-- Right Column (Widgets) --}}
        <div class="lg:col-span-4 space-y-6">
            
            {{-- CTA Card --}}
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-3xl p-8 text-white shadow-lg shadow-indigo-200" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
                <h3 class="text-2xl font-extrabold mb-4 leading-tight">Apa yang Anda pelajari hari ini?</h3>
                <p class="text-sm font-medium text-indigo-100 leading-relaxed mb-6">
                    Menulis jurnal membantu Anda mengingat materi 40% lebih baik dan meningkatkan kesadaran emosional.
                </p>
                <a href="{{ route('journal.create') }}" class="inline-flex items-center justify-center gap-2 w-full py-3 bg-white text-indigo-600 font-bold rounded-xl hover:bg-slate-50 transition-colors shadow-sm" style="color: #4f46e5;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    Tulis Jurnal Baru
                </a>
            </div>

            {{-- Statistics --}}
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                <h4 class="text-[11px] font-bold text-slate-400 tracking-widest uppercase mb-4">Statistik Jurnal</h4>
                
                <div class="space-y-3">
                    {{-- Streak --}}
                    <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0" style="color: #4f46e5;">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Streak</p>
                            <p class="text-base font-extrabold text-slate-900">{{ $streak->current_streak ?? 0 }} Hari</p>
                        </div>
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" /></svg>
                    </div>

                    {{-- Total Entries --}}
                    <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl">
                        <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" /></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Total Entri</p>
                            <p class="text-base font-extrabold text-slate-900">{{ $journals->total() }} Jurnal</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Featured Article --}}
            @if($featuredArticle)
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <div class="h-32 bg-slate-200 relative overflow-hidden">
                    @if($featuredArticle->cover_image_url)
                        <img src="{{ $featuredArticle->cover_image_url }}" class="w-full h-full object-cover" alt="{{ $featuredArticle->title }}">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <svg class="w-10 h-10 text-white/30" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
                        </div>
                    @endif
                </div>
                <div class="p-5 bg-indigo-50/50">
                    <p class="text-[10px] font-bold text-indigo-600 uppercase tracking-wide mb-1.5" style="color: #4f46e5;">Artikel Pilihan</p>
                    <h4 class="text-sm font-extrabold text-slate-900 leading-snug mb-3 line-clamp-2">{{ $featuredArticle->title }}</h4>
                    <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-700 transition-colors" style="color: #4f46e5;">
                        Baca Sekarang 
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                    </a>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

@push('scripts')
<script>
    // Get real journal days from PHP
    const userJournalDays = @json($journalDays ?? []);

    document.addEventListener('alpine:init', () => {
        Alpine.data('calendar', () => ({
            month: new Date().getMonth(),
            year: new Date().getFullYear(),
            monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            
            get daysInMonth() {
                return new Date(this.year, this.month + 1, 0).getDate();
            },
            
            get blankDays() {
                let start = new Date(this.year, this.month, 1).getDay();
                // 0 = Sunday in JS, so it matches perfectly if our headers start with MIN (Minggu)
                return Array.from({ length: start });
            },
            
            isToday(day) {
                const today = new Date();
                return day === today.getDate() && this.month === today.getMonth() && this.year === today.getFullYear();
            },
            
            hasJournal(day) {
                // Return true if the current viewed month is this month, and the day is in the DB
                // Wait, if the month changes, we would need dynamic checking for that month. 
                // But for now, userJournalDays only contains days for the current month!
                const today = new Date();
                if (this.month === today.getMonth() && this.year === today.getFullYear()) {
                    return userJournalDays.includes(day);
                }
                return false;
            },
            
            nextMonth() {
                if (this.month === 11) {
                    this.month = 0;
                    this.year++;
                } else {
                    this.month++;
                }
            },
            
            prevMonth() {
                if (this.month === 0) {
                    this.month = 11;
                    this.year--;
                } else {
                    this.month--;
                }
            },
            
            selectDate(day) {
                // Mock selection logic
                console.log(`Selected ${day} ${this.monthNames[this.month]} ${this.year}`);
            }
        }));
    });
</script>
@endpush

@endsection
