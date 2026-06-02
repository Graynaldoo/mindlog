@extends('layouts.app')
@section('title', 'Artikel Edukasi - MindLog EduSmart')

@section('content')
<div class="space-y-6 animate-fade-in max-w-7xl mx-auto">

    {{-- ── Header + Category Filter ──────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Artikel Edukasi</h1>
            <p class="text-sm text-slate-500 mt-1 max-w-sm leading-relaxed">
                Jelajahi wawasan terbaru tentang literasi digital dan pengembangan diri.
            </p>
        </div>

        {{-- Category Filter Tabs --}}
        <div class="flex flex-wrap items-center gap-2 md:pt-1">
            <a href="{{ route('articles.index') }}"
               class="px-4 py-1.5 rounded-full text-xs font-bold border transition-all duration-150"
               style="{{ !$activeCategory ? 'background:#4f46e5;color:#fff;border-color:#4f46e5;box-shadow:0 2px 8px rgba(79,70,229,0.25)' : 'background:#fff;color:#475569;border-color:#e2e8f0' }}">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('articles.index', ['category' => $cat->slug]) }}"
                   class="px-4 py-1.5 rounded-full text-xs font-bold border transition-all duration-150"
                   style="{{ ($activeCategory && $activeCategory->id === $cat->id) ? 'background:#4f46e5;color:#fff;border-color:#4f46e5;box-shadow:0 2px 8px rgba(79,70,229,0.25)' : 'background:#fff;color:#475569;border-color:#e2e8f0' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- ── Featured / Hero Article ─────────────────── --}}
    @if($featured)
        @php
            /* Warna hero berdasarkan kategori ID */
            $heroColors = [
                1 => ['from' => '#1e1b4b', 'to' => '#312e81', 'accent' => '#6366f1'],
                2 => ['from' => '#1c1917', 'to' => '#44403c', 'accent' => '#f59e0b'],
                3 => ['from' => '#052e16', 'to' => '#166534', 'accent' => '#10b981'],
                4 => ['from' => '#4c0519', 'to' => '#9f1239', 'accent' => '#f43f5e'],
                5 => ['from' => '#0c4a6e', 'to' => '#075985', 'accent' => '#0ea5e9'],
            ];
            $hc = $heroColors[($featured->category_id % 5) + 1];
        @endphp

        <a href="{{ route('articles.show', $featured->slug) }}"
           class="block relative rounded-2xl overflow-hidden group"
           style="min-height:320px; background: linear-gradient(135deg, {{ $hc['from'] }}, {{ $hc['to'] }});">

            {{-- Decorative blobs --}}
            <div class="absolute top-0 right-0 w-72 h-72 rounded-full opacity-20 pointer-events-none"
                 style="background: radial-gradient(circle, {{ $hc['accent'] }}, transparent 70%); transform: translate(20%, -20%);"></div>
            <div class="absolute bottom-0 left-0 w-56 h-56 rounded-full opacity-10 pointer-events-none"
                 style="background: radial-gradient(circle, {{ $hc['accent'] }}, transparent 70%); transform: translate(-20%, 20%);"></div>

            {{-- Dark overlay bottom --}}
            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.15) 60%, transparent 100%);"></div>

            {{-- Content --}}
            <div class="relative z-10 p-8 md:p-10 flex flex-col justify-end" style="min-height:320px;">
                <div class="flex items-center gap-2 mb-4">
                    <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest text-white"
                          style="background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(4px);">
                        {{ $featured->category->sdg_focus ?? $featured->category->name }}
                    </span>
                    <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest text-white"
                          style="background: {{ $hc['accent'] }}cc; backdrop-filter: blur(4px);">
                        Pilihan Redaksi
                    </span>
                </div>

                <h2 class="text-2xl md:text-3xl font-extrabold text-white leading-tight mb-3 max-w-2xl">
                    {{ $featured->title }}
                </h2>
                <p class="text-sm leading-relaxed mb-6 max-w-xl line-clamp-2" style="color: rgba(255,255,255,0.72);">
                    {{ $featured->excerpt }}
                </p>

                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center gap-2 px-5 py-2.5 text-xs font-bold rounded-full transition-colors"
                          style="background: #fff; color: #1e293b;">
                        Baca Selengkapnya
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                        </svg>
                    </span>
                    <span class="flex items-center gap-1.5 text-xs font-medium" style="color: rgba(255,255,255,0.65);">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                        </svg>
                        {{ $featured->estimated_minutes }} Menit Baca
                    </span>
                </div>
            </div>
        </a>
    @endif

    {{-- ── Articles Grid ────────────────────────────── --}}
    @php
        /* Palet warna per card (inline style, pasti tampil) */
        $cardColors = [
            ['bg' => 'linear-gradient(135deg,#312e81,#4338ca)', 'badge' => '#818cf8'],
            ['bg' => 'linear-gradient(135deg,#92400e,#b45309)', 'badge' => '#fbbf24'],
            ['bg' => 'linear-gradient(135deg,#065f46,#047857)', 'badge' => '#34d399'],
            ['bg' => 'linear-gradient(135deg,#881337,#be123c)', 'badge' => '#fb7185'],
            ['bg' => 'linear-gradient(135deg,#075985,#0284c7)', 'badge' => '#38bdf8'],
            ['bg' => 'linear-gradient(135deg,#1e293b,#334155)', 'badge' => '#94a3b8'],
        ];
    @endphp

    @if($articles->count() > 0)
        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3 stagger-children">
            @foreach($articles as $article)
                @php $cc = $cardColors[$loop->index % 6]; @endphp
                <a href="{{ route('articles.show', $article->slug) }}"
                   class="group bg-white rounded-2xl border border-slate-200 overflow-hidden flex flex-col"
                   style="transition: transform 0.2s, box-shadow 0.2s;"
                   onmouseenter="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(0,0,0,0.1)'"
                   onmouseleave="this.style.transform='';this.style.boxShadow=''">

                    {{-- Thumbnail --}}
                    <div class="relative overflow-hidden flex-shrink-0" style="height:176px; {{ $cc['bg'] }}; background: {{ $cc['bg'] }};">
                        {{-- Decorative dots pattern --}}
                        <div class="absolute inset-0 opacity-10"
                             style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 20px 20px;"></div>
                        {{-- Blob --}}
                        <div class="absolute -bottom-4 -right-4 w-32 h-32 rounded-full opacity-20"
                             style="background: {{ $cc['badge'] }};"></div>

                        {{-- Category badge --}}
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest text-white"
                                  style="background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.25); backdrop-filter: blur(4px);">
                                {{ $article->category->name }}
                            </span>
                        </div>

                        {{-- Center icon --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <svg class="w-14 h-14 opacity-10" fill="none" stroke="#fff" stroke-width="0.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0118 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-5 flex flex-col flex-1">
                        {{-- Meta --}}
                        <div class="flex items-center gap-1.5 mb-2.5" style="font-size:11px; font-weight:600; color:#94a3b8;">
                            <span>{{ $article->published_at ? $article->published_at->translatedFormat('d M Y') : 'Draft' }}</span>
                            <span>•</span>
                            <span>Oleh {{ $article->author->name ?? 'Admin' }}</span>
                        </div>

                        {{-- Title --}}
                        <h2 class="font-extrabold text-slate-900 leading-snug mb-2 line-clamp-2"
                            style="font-size:15px; transition: color 0.15s;"
                            onmouseenter="this.style.color='#4f46e5'"
                            onmouseleave="this.style.color=''">
                            {{ $article->title }}
                        </h2>

                        {{-- Excerpt --}}
                        <p class="line-clamp-3 flex-1" style="font-size:12px; font-weight:500; color:#64748b; line-height:1.6;">
                            {{ $article->excerpt }}
                        </p>

                        {{-- Footer --}}
                        <div class="mt-4 pt-3 flex items-center gap-1.5" style="border-top: 1px solid #f1f5f9; font-size:11px; font-weight:600; color:#94a3b8;">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/>
                            </svg>
                            {{ $article->estimated_minutes }} menit baca
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($articles->hasPages())
            <div class="mt-6">{{ $articles->links() }}</div>
        @endif

    @else
        <div class="py-20 text-center bg-white rounded-2xl border border-slate-200">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4"
                 style="background:#f8fafc; color:#94a3b8;">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                </svg>
            </div>
            <h3 class="font-bold text-slate-800 mb-1" style="font-size:15px;">Belum Ada Artikel</h3>
            <p style="font-size:13px; color:#64748b;">
                @if($activeCategory)
                    Belum ada artikel di kategori <strong>{{ $activeCategory->name }}</strong>.
                @else
                    Materi edukasi akan segera ditambahkan.
                @endif
            </p>
        </div>
    @endif

</div>
@endsection
