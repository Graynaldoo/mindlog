@extends('layouts.app')
@section('title', $article->title)

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">

    {{-- Back Action --}}
    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('articles.index') }}"
           class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Kembali Ke Daftar
        </a>

        @can('update', $article)
            <div class="flex items-center gap-3">
                <a href="{{ route('articles.edit', $article) }}" class="btn btn-secondary btn-sm">Edit</a>
                <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Yakin hapus artikel?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </div>
        @endcan
    </div>

    {{-- Main Article Card --}}
    <article class="card p-8 md:p-12 relative overflow-hidden bg-white">
        {{-- Decorative Top Gradient --}}
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-indigo-500 via-violet-500 to-indigo-500"></div>

        <header class="mb-10 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-slate-50 border border-slate-200 mb-6">
                <span class="text-[11px] font-bold tracking-wide text-indigo-700">{{ $article->category->name }}</span>
            </div>
            
            <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 leading-tight mb-6">
                {{ $article->title }}
            </h1>

            <div class="flex flex-wrap items-center justify-center gap-6 text-sm font-medium text-slate-500">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600">
                        {{ strtoupper(substr($article->author->name, 0, 1)) }}
                    </div>
                    <span>{{ $article->author->name }}</span>
                </div>
                <div class="w-1 h-1 rounded-full bg-slate-300 hidden sm:block"></div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/></svg>
                    <time datetime="{{ $article->published_at }}">{{ $article->published_at ? $article->published_at->translatedFormat('d M Y') : 'Draft' }}</time>
                </div>
                <div class="w-1 h-1 rounded-full bg-slate-300 hidden sm:block"></div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $article->estimated_minutes }} Menit Baca</span>
                </div>
                <div class="w-1 h-1 rounded-full bg-slate-300 hidden sm:block"></div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ $article->read_count }} Dibaca</span>
                </div>
            </div>
        </header>

        <div class="prose prose-slate prose-lg max-w-none text-slate-700 leading-relaxed font-medium">
            {!! Str::markdown($article->content) !!}
        </div>

    </article>

    {{-- Bottom Action for Learning Logging --}}
    @if(auth()->user()->hasRole('user'))
        <div class="mt-8 bg-indigo-50 border border-indigo-100 rounded-2xl p-6 text-center shadow-sm">
            <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mx-auto mb-3">
                <span class="text-xl">💡</span>
            </div>
            <h3 class="text-sm font-bold text-indigo-900 mb-2">Telah Selesai Membaca?</h3>
            <p class="text-xs text-indigo-700/80 mb-4 max-w-md mx-auto">
                Tuliskan apa yang Anda pelajari dari artikel ini ke dalam Jurnal Harian untuk memperkuat ingatan dan meningkatkan statistik belajar Anda!
            </p>
            <a href="{{ route('journal.create', ['article_id' => $article->id]) }}" class="btn btn-primary btn-sm">
                Tulis Refleksi Jurnal
            </a>
        </div>
    @endif
</div>
@endsection
