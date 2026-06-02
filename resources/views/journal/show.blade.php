@extends('layouts.app')
@section('title', $journal->title)

@section('content')
<div class="max-w-3xl mx-auto animate-fade-in">
    {{-- Action header --}}
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('journal.index') }}"
           class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Kembali Ke Riwayat
        </a>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('journal.edit', $journal) }}" class="btn btn-secondary btn-sm">
                Edit Jurnal
            </a>
            <form method="POST" action="{{ route('journal.destroy', $journal) }}"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Detail Reading Canvas --}}
    <article class="card p-8 md:p-12 relative overflow-hidden">
        {{-- Elegant Mood Top Bar Indicator --}}
        <div class="absolute top-0 left-0 w-full h-2" style="background-color: {{ $journal->mood->color }}"></div>

        {{-- Meta Info --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-8 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center border"
                     style="background-color: {{ $journal->mood->color }}15; border-color: {{ $journal->mood->color }}30">
                    <x-mood-icon :score="$journal->mood->score" class="w-8 h-8" :color="$journal->mood->color" />
                </div>
                <div>
                    <time class="text-sm font-extrabold text-slate-800 block">
                        {{ $journal->journal_date->translatedFormat('l, d F Y') }}
                    </time>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest mt-2 border"
                          style="background-color: {{ $journal->mood->color }}12; color: {{ $journal->mood->color }}; border-color: {{ $journal->mood->color }}25">
                        {{ $journal->mood->name }}
                    </span>
                </div>
            </div>

            @if($journal->is_private)
                <div class="inline-flex items-center gap-1.5 text-[11px] font-extrabold bg-slate-50 border border-slate-200 text-slate-500 px-3 py-1.5 rounded-full uppercase tracking-wider self-start sm:self-auto select-none">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    Privat
                </div>
            @endif
        </div>

        {{-- Title --}}
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight mb-8">
            {{ $journal->title }}
        </h1>

        {{-- Content Body --}}
        <div class="prose prose-slate max-w-none text-slate-700 text-base leading-loose font-medium">
            {!! nl2br(e($journal->content)) !!}
        </div>
    </article>

    <div class="mt-10 text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest">
        Dikelola oleh MindLog EduSmart System.
    </div>
</div>
@endsection
