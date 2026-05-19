@extends('layouts.app')
@section('title', $journal->title)

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Back navigation & action header --}}
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('journal.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
            </svg>
            Kembali Ke Riwayat
        </a>
        
        <div class="flex items-center gap-2">
            <a href="{{ route('journal.edit', $journal) }}"
               class="px-4 py-2 bg-gray-50 hover:bg-gray-100 border border-gray-150 text-gray-600 font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-200">
                Edit Jurnal
            </a>
            
            <form method="POST" action="{{ route('journal.destroy', $journal) }}"
                  onsubmit="return confirm('Apakah kamu yakin ingin menghapus catatan sejarah emosi ini?')">
                @csrf @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-200 cursor-pointer">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Detail Reading Canvas --}}
    <article class="bg-white rounded-3xl p-6 md:p-10 border border-gray-100/70 shadow-sm relative overflow-hidden">
        {{-- Elegant Mood Top Bar Indicator --}}
        <div class="absolute top-0 left-0 w-full h-1.5" style="background-color: {{ $journal->mood->color }}"></div>

        {{-- Meta Info --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-50 pb-6 mb-6">
            <div class="flex items-center gap-3.5">
                <x-mood-icon :score="$journal->mood->score" :color="$journal->mood->color" class="w-12 h-12 flex-shrink-0" />
                <div>
                    <time class="text-xs font-bold text-gray-400 uppercase tracking-wide block">
                        {{ $journal->journal_date->translatedFormat('l, d F Y') }}
                    </time>
                    <span class="inline-flex text-[9px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full mt-1.5 border"
                          style="background-color: {{ $journal->mood->color }}12; color: {{ $journal->mood->color }}; border-color: {{ $journal->mood->color }}25">
                        {{ $journal->mood->name }}
                    </span>
                </div>
            </div>

            @if($journal->is_private)
                <span class="text-[10px] font-bold bg-gray-50 border border-gray-100 text-gray-400 px-3 py-1 rounded-full self-start sm:self-auto select-none">🔒 Jurnal Privat</span>
            @endif
        </div>

        {{-- Title --}}
        <h1 class="font-display text-4xl font-bold text-gray-900 leading-tight mb-6">
            {{ $journal->title }}
        </h1>

        {{-- Content Body --}}
        <div class="prose prose-gray max-w-none text-gray-700 text-sm leading-relaxed whitespace-pre-line font-medium pl-0.5">
            {!! nl2br(e($journal->content)) !!}
        </div>
    </article>

    {{-- Bottom Decorative Quote/Reminder --}}
    <div class="mt-8 text-center text-[10px] font-bold text-gray-300 uppercase tracking-widest">
        ✍️ Dirawat dengan penuh kasih sayang oleh MindLog.
    </div>
</div>
@endsection
