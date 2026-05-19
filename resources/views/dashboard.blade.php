@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Custom Style for Breathing Animation & Dissolve Effects --}}
<style>
    @keyframes breathe {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 0 25px 5px rgba(124, 58, 237, 0.15);
            background-color: rgba(124, 58, 237, 0.08);
        }
        50% {
            transform: scale(1.25);
            box-shadow: 0 0 45px 15px rgba(124, 58, 237, 0.35);
            background-color: rgba(124, 58, 237, 0.18);
        }
    }
    .breathe-circle {
        animation: breathe 5s infinite ease-in-out;
    }
    .dissolve-transition {
        transition: all 1.8s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
</style>

{{-- ── 2-COLUMN MAIN LAYOUT ────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ── LEFT COLUMN (2/3 Width): Main Reflector & Chart ── --}}
    <div class="lg:col-span-2 space-y-8">
        
        {{-- Greeting Header --}}
        <div class="flex items-center justify-between">
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-violet-500">MindLog Ruang Refleksi</span>
                <h1 class="font-display text-4xl font-bold text-gray-900 mt-1">
                    @php
                        $hour = date('H');
                        $greeting = 'Halo';
                        if ($hour >= 5 && $hour < 12) {
                            $greeting = 'Selamat Pagi';
                        } elseif ($hour >= 12 && $hour < 17) {
                            $greeting = 'Selamat Siang';
                        } elseif ($hour >= 17 && $hour < 20) {
                            $greeting = 'Selamat Sore';
                        } else {
                            $greeting = 'Selamat Malam';
                        }
                    @endphp
                    {{ $greeting }}, {{ auth()->user()->name }}
                </h1>
                <p class="text-xs text-gray-400 font-semibold mt-1">
                    📅 {{ now()->translatedFormat('l, d F Y') }} — Yuk, luangkan waktu sejenak.
                </p>
            </div>
        </div>

        {{-- Beautiful Minimal Quote --}}
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-violet-500 rounded-l-3xl"></div>
            <div class="flex items-start gap-4">
                <span class="text-3xl text-violet-300 font-serif leading-none select-none">“</span>
                <div class="flex-1">
                    <p class="font-display text-lg italic text-gray-700 leading-relaxed">
                        {{ $quote['text'] }}
                    </p>
                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-2">
                        — {{ $quote['author'] }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Mood Check-in Card (Wide Format - No Cramming!) --}}
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="font-bold text-gray-900 text-base">Bagaimana Perasaanmu Hari Ini?</h2>
                    <p class="text-[10px] text-gray-400 font-semibold mt-0.5">Ketuk emoji untuk mencatat mood atau membuat jurnal otomatis:</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center shadow-inner select-none">
                    @if($todayMood)
                        <x-mood-icon :score="$todayMood->score" :color="$todayMood->color" class="w-7 h-7" />
                    @else
                        <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-5 gap-3">
                @foreach($moods as $mood)
                    <form action="{{ route('mood.set') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="mood_id" value="{{ $mood->id }}">
                        <button type="submit" 
                            class="w-full py-4 px-2 rounded-2xl border transition-all duration-200 flex flex-col items-center gap-2 cursor-pointer
                            {{ $todayMood && $todayMood->id == $mood->id 
                                ? 'bg-violet-50/50 border-violet-300 ring-2 ring-violet-500/20 shadow-sm' 
                                : 'bg-gray-50/40 border-gray-100 hover:border-violet-200 hover:bg-violet-50/20 hover:-translate-y-0.5' 
                            }}">
                            <x-mood-icon :score="$mood->score" class="w-8 h-8 transition-transform duration-200 {{ $todayMood && $todayMood->id == $mood->id ? 'scale-110' : '' }}" :color="$mood->color" />
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider leading-none text-center">{{ $mood->name }}</span>
                        </button>
                    </form>
                @endforeach
            </div>

            @if($todayMood)
                <p class="text-xs text-center text-gray-400 mt-4 italic font-semibold">
                    Kamu mencatat perasaan <span class="text-violet-600 font-extrabold">{{ $todayMood->name }}</span> untuk hari ini.
                </p>
            @endif
        </div>

        {{-- Weekly Mood Trend Chart --}}
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <h2 class="font-bold text-gray-900 text-base mb-4">Grafik Mood Mingguan</h2>
            @if($weeklyMoods->count() > 0)
                <div class="relative w-full h-[220px]">
                    <canvas id="moodChart" class="w-full h-full"></canvas>
                </div>
            @else
                <div class="text-center py-10 text-gray-400">
                    <span class="text-3xl block mb-2">📊</span>
                    <p class="text-xs font-semibold">Belum ada data grafik mood untuk minggu ini.</p>
                </div>
            @endif
        </div>

        {{-- 🌊 NEW INNOVATION: CATHARSIS STRESS RELEASE BOX --}}
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm" x-data="{ 
            stressText: '', 
            isDissolved: false, 
            showBreathing: false,
            resetState() {
                this.stressText = '';
                this.isDissolved = false;
                this.showBreathing = false;
            },
            hanyutkan() {
                if (this.stressText.trim() === '') return;
                this.isDissolved = true;
                setTimeout(() => {
                    this.showBreathing = true;
                }, 2000);
            }
        }">
            <div class="flex items-center gap-3.5 mb-3.5">
                <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center shadow-inner select-none text-violet-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12c4-4 8-4 12 0s8 4 12 0M3 16c4-4 8-4 12 0s8 4 12 0" />
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-gray-900 text-base">Kotak Pelepasan Stres & Dekompresi</h2>
                    <p class="text-[10px] text-gray-400 font-semibold mt-0.5">Tuliskan pikiran negatif, kemarahan, atau kecemasanmu, lalu hanyutkan agar pergi dari benakmu.</p>
                </div>
            </div>

            {{-- Textarea block (will dissolve with CSS filter blur/fade) --}}
            <div x-show="!showBreathing" class="space-y-4">
                <textarea x-model="stressText" 
                          :class="isDissolved ? 'opacity-0 scale-95 blur-md pointer-events-none' : ''"
                          placeholder="Ketik apa saja yang mengganjal di hatimu di sini... (Catatan ini tidak disimpan di database, murni untuk katarsismu)"
                          class="w-full h-32 px-4 py-3.5 rounded-2xl border border-gray-150 focus:border-violet-300 focus:ring-4 focus:ring-violet-500/5 focus:outline-none text-xs text-gray-700 bg-gray-50/20 font-medium resize-none dissolve-transition leading-relaxed"></textarea>
                
                <div class="flex justify-end">
                    <button type="button" 
                            @click="hanyutkan()"
                            :disabled="stressText.trim() === '' || isDissolved"
                            class="px-5 py-3 rounded-2xl bg-violet-600 hover:bg-violet-700 text-white text-xs font-bold uppercase tracking-wider transition-all duration-200 disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer shadow-md shadow-violet-100 flex items-center gap-1.5">
                        <span x-text="isDissolved ? 'Sedang Menghanyutkan...' : 'Hanyutkan & Relakan 🌊'"></span>
                    </button>
                </div>
            </div>

            {{-- Calming breathing animation block --}}
            <div x-show="showBreathing" x-transition class="flex flex-col items-center justify-center py-6 text-center">
                <div class="w-24 h-24 rounded-full breathe-circle flex items-center justify-center select-none mb-6 text-violet-600">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.2 2-3.6 4-6 4 2.4 0 4.8 2 6 4 1.2-2 3.6-4 6-4-2.4 0-4.8-2-6-4z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21c-1.2-2-3.6-4-6-4 2.4 0 4.8-2 6-4 1.2 2 3.6 4 6 4-2.4 0-4.8 2-6 4z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c-2-1.2-4-3.6-4-6 0 2.4 2 4.8 4 6-2 1.2-4 3.6-4 6 0-2.4 2-4.8 4-6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2-1.2 4-3.6 4-6 0 2.4-2 4.8-4 6 2 1.2 4 3.6 4 6 0-2.4-2-4.8-4-6z" />
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 text-sm">Tarik napas dalam-dalam... Hembuskan perlahan...</h3>
                <p class="text-xs text-gray-400 font-semibold mt-1.5 max-w-sm">Kekhawatiranmu telah dilepaskan dan dihanyutkan. Berikan dirimu waktu jeda sejenak untuk tenang.</p>
                
                <button type="button" 
                        @click="resetState()"
                        class="mt-6 px-4 py-2.5 rounded-xl border border-gray-200 hover:bg-gray-50 text-gray-600 text-[10px] font-extrabold uppercase tracking-widest transition-colors cursor-pointer">
                    Mulai Lembaran Baru ✨
                </button>
            </div>
        </div>

        {{-- Recent Journals --}}
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="font-bold text-gray-900 text-base">Jurnal Terbaru</h2>
                <a href="{{ route('journal.index') }}" class="text-xs font-bold text-violet-600 hover:text-violet-800 transition-colors uppercase tracking-wider flex items-center gap-1">
                    Semua Jurnal
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            </div>

            @if($recentJournals->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach($recentJournals as $journal)
                        <x-journal-card :journal="$journal" />
                    @endforeach
                </div>
            @else
                <div class="text-center py-10 bg-white border border-gray-100 rounded-3xl">
                    <p class="text-4xl mb-2">📖</p>
                    <p class="text-xs font-semibold text-gray-800">Belum ada jurnal tersimpan.</p>
                </div>
            @endif
        </div>

    </div>

    {{-- ── RIGHT COLUMN (1/3 Width): Sidebar Widgets & Stats ── --}}
    <div class="space-y-8">
        
        {{-- Streak Harian Widget --}}
        <x-streak-card :streak="$streak" />

        {{-- Monthly Stats & Mood Landscape --}}
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Bulan Ini</span>
                    <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center text-violet-600 select-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>

                <div class="flex items-baseline gap-2 mb-1">
                    <span class="text-5xl font-display font-bold tracking-tight text-gray-900">
                        {{ $monthlyStats['total_journals'] }}
                    </span>
                    <span class="text-xs font-semibold text-gray-400">Jurnal Ditulis</span>
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-gray-50">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-3">Lanskap Emosi Bulan Ini</span>
                
                @if(count($monthlyStats['mood_distribution']) > 0)
                    <div class="space-y-3">
                        @foreach($monthlyStats['mood_distribution'] as $dist)
                            @php
                                $percentage = ($monthlyStats['total_journals'] > 0) 
                                    ? round(($dist['count'] / $monthlyStats['total_journals']) * 100) 
                                    : 0;
                            @endphp
                            <div>
                                <div class="flex items-center justify-between text-[10px] font-bold text-gray-500 mb-1">
                                    <span class="flex items-center gap-2">
                                        <x-mood-icon :score="$dist['mood']->score" :color="$dist['mood']->color" class="w-6 h-6 flex-shrink-0" />
                                        <span>{{ $dist['mood']->name }}</span>
                                    </span>
                                    <span>{{ $dist['count'] }} Entri ({{ $percentage }}%)</span>
                                </div>
                                <div class="w-full h-2 bg-gray-50 border border-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full transition-all duration-500" 
                                         style="width: {{ $percentage }}%; background-color: {{ $dist['mood']->color }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-[10px] text-gray-400 italic text-center py-2">
                        Belum ada rekaman emosi bulan ini.
                    </p>
                @endif
            </div>
        </div>

        {{-- Mindfulness Gratitude Tracker Tag Widget --}}
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm" x-data="{ 
            selectedTags: [],
            tags: [
                { name: 'Keluarga 👨', quote: 'Keluarga adalah rumah bagi jiwa.' },
                { name: 'Kesehatan 🍎', quote: 'Kesehatan adalah anugerah terbesar.' },
                { name: 'Kerja/Studi 📚', quote: 'Setiap usaha membawa kemajuan.' },
                { name: 'Sahabat 👥', quote: 'Persahabatan menghangatkan hari.' },
                { name: 'Hobi 🎨', quote: 'Waktu kreasi membebaskan stres.' },
                { name: 'Ketenangan ☕', quote: 'Jeda tenang menjernihkan batin.' },
                { name: 'Makanan 🍕', quote: 'Keberkahan dalam setiap suapan.' }
            ],
            toggleTag(name) {
                if (this.selectedTags.includes(name)) {
                    this.selectedTags = this.selectedTags.filter(t => t !== name);
                } else {
                    if (this.selectedTags.length < 3) this.selectedTags.push(name);
                }
            }
        }">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">Gratitude Check (Syukur)</h3>
                    <p class="text-[9px] text-gray-400 font-semibold mt-0.5">Pilih maksimal 3 hal yang disyukuri:</p>
                </div>
                <span class="text-[9px] font-bold text-violet-600 bg-violet-50 px-2 py-0.5 rounded-full" x-text="selectedTags.length + '/3'">0/3</span>
            </div>

            <div class="flex flex-wrap gap-1.5 my-3">
                <template x-for="tag in tags" :key="tag.name">
                    <button type="button" 
                            @click="toggleTag(tag.name)"
                            :class="selectedTags.includes(tag.name)
                                ? 'bg-violet-600 text-white border-violet-600 shadow-sm shadow-violet-100'
                                : 'bg-gray-50 text-gray-500 border-gray-100 hover:bg-gray-100/50'"
                            class="px-3 py-1.5 rounded-xl border text-[10px] font-bold transition-all duration-200 cursor-pointer">
                        <span x-text="tag.name"></span>
                    </button>
                </template>
            </div>

            <div class="bg-gray-50/50 rounded-xl p-3 border border-gray-100 transition-all duration-300" x-show="selectedTags.length > 0" x-transition>
                <div class="text-[10px] font-bold text-violet-600 uppercase tracking-widest mb-1.5">Afirmasi Hari Ini</div>
                <div class="text-[10px] font-medium text-gray-600 space-y-1">
                    <template x-for="name in selectedTags" :key="name">
                        <p>✨ <span class="font-bold text-gray-800" x-text="name.split(' ')[0]"></span>: <span class="italic text-gray-400" x-text="tags.find(t => t.name === name).quote"></span></p>
                    </template>
                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@php
    $chartData = [];
    foreach ($weeklyMoods as $j) {
        $chartData[] = [
            'label' => $j->journal_date->format('d M'),
            'score' => $j->mood->score,
            'color' => $j->mood->color,
        ];
    }
@endphp

<script>
document.addEventListener("DOMContentLoaded", function() {
    const weeklyData = {!! json_encode($chartData) !!};

    if (weeklyData.length > 0) {
        const ctx = document.getElementById('moodChart').getContext('2d');
        
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(124, 58, 237, 0.12)');
        gradient.addColorStop(1, 'rgba(124, 58, 237, 0.00)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: weeklyData.map(d => d.label),
                datasets: [{
                    label: 'Skor Mood',
                    data: weeklyData.map(d => d.score),
                    borderColor: '#7C3AED',
                    backgroundColor: gradient,
                    borderWidth: 2.5,
                    pointBackgroundColor: weeklyData.map(d => d.color),
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.35,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1E1B4B',
                        titleFont: { family: 'Plus Jakarta Sans', size: 11, weight: 'bold' },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 11 },
                        padding: 9,
                        cornerRadius: 10,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                const moodNames = ['Sangat Sedih', 'Sedih', 'Biasa', 'Senang', 'Sangat Senang'];
                                return 'Mood: ' + moodNames[context.raw - 1] + ' (' + context.raw + '/5)';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        min: 1,
                        max: 5,
                        ticks: {
                            stepSize: 1,
                            font: { family: 'Plus Jakarta Sans', size: 9, weight: '700' },
                            color: '#9CA3AF',
                            callback: function(value) {
                                const emojis = ['', '😢', '🙁', '😐', '🙂', '😊'];
                                return emojis[value] + ' ' + value;
                            }
                        },
                        grid: { color: 'rgba(243, 244, 246, 0.7)' },
                        border: { dash: [4, 4] }
                    },
                    x: {
                        ticks: { font: { family: 'Plus Jakarta Sans', size: 9, weight: '700' }, color: '#9CA3AF' },
                        grid: { display: false }
                    }
                }
            }
        });
    }
});
</script>
@endpush