@extends('layouts.app')
@section('title', 'Kelola Artikel - MindLog EduSmart')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto animate-fade-in">
    {{-- Header --}}
    <div class="card p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 mb-3">
                <span class="text-[11px] font-bold tracking-wide text-indigo-700 uppercase">Ruang Redaksi</span>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Artikel</h1>
            <p class="text-sm font-medium text-slate-500 mt-2 max-w-2xl leading-relaxed">
                Buat dan kelola materi edukasi untuk pengguna platform.
            </p>
        </div>
        <div class="flex-shrink-0 text-center">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center text-2xl font-extrabold shadow-lg shadow-indigo-200 mx-auto mb-1.5">
                {{ $articles->total() }}
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Terpublikasi</span>
        </div>
    </div>

    {{-- Articles List --}}
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3 stagger-children">
        @foreach($articles as $article)
            <div class="card p-5 hover:border-indigo-200 group transition-all flex flex-col h-full bg-white relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-400 to-violet-400"></div>
                
                <div class="flex items-start justify-between mb-4 flex-1">
                    <span class="badge-primary inline-flex mt-2">{{ $article->category->name }}</span>
                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('articles.show', $article) }}" target="_blank" class="p-1.5 text-slate-400 hover:text-emerald-600 bg-white rounded-md shadow-sm border border-slate-200" title="Lihat Artikel">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </a>
                        <a href="{{ route('articles.edit', $article) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 bg-white rounded-md shadow-sm border border-slate-200" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('articles.destroy', $article) }}" onsubmit="return confirm('Hapus artikel ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 bg-white rounded-md shadow-sm border border-slate-200" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                
                <h3 class="text-base font-extrabold text-slate-900 mb-2 leading-tight">{{ $article->title }}</h3>
                <p class="text-xs font-medium text-slate-500 line-clamp-2 leading-relaxed mb-6">{{ $article->excerpt }}</p>
                
                <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <span>Oleh {{ $article->author->name }}</span>
                    <span>{{ $article->read_count }} Dibaca</span>
                </div>
            </div>
        @endforeach
    </div>

    @if($articles->hasPages())
        <div class="mt-6">
            {{ $articles->links() }}
        </div>
    @endif

    {{-- Add Article Button --}}
    <div class="flex justify-center">
        <a href="{{ route('articles.create') }}" class="btn btn-primary px-8 py-3 text-base">
            + Tulis Artikel Baru
        </a>
    </div>
</div>
@endsection
