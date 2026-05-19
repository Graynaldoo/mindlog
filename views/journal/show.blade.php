@extends('layouts.app')
@section('title', $journal->title)

@section('content')
<div class="max-w-2xl">
    {{-- Back + actions --}}
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('journal.index') }}"
           class="text-sm text-gray-400 hover:text-gray-700">← Jurnal Saya</a>
        <div class="flex gap-2">
            <a href="{{ route('journal.edit', $journal) }}"
               class="px-3 py-1.5 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                Edit
            </a>
            <form method="POST" action="{{ route('journal.destroy', $journal) }}"
                  onsubmit="return confirm('Hapus jurnal ini?')">
                @csrf @method('DELETE')
                <button class="px-3 py-1.5 text-sm bg-red-50 hover:bg-red-100 text-red-600 rounded-lg transition-colors">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-3">
            <span class="text-4xl">{{ $journal->mood->emoji }}</span>
            <div>
                <p class="text-xs text-gray-400">
                    {{ $journal->journal_date->translatedFormat('l, d F Y') }}
                </p>
                <span class="inline-flex text-xs font-medium px-2 py-0.5 rounded-full mt-1"
                      style="background-color: {{ $journal->mood->color }}22; color: {{ $journal->mood->color }}">
                    {{ $journal->mood->name }}
                </span>
            </div>
        </div>
        <h1 class="font-display text-4xl text-gray-900">{{ $journal->title }}</h1>
    </div>

    {{-- Content --}}
    <div class="bg-white rounded-2xl p-7 border border-gray-100">
        <div class="prose prose-gray max-w-none text-gray-700 leading-relaxed">
            {!! nl2br(e($journal->content)) !!}
        </div>
    </div>

    @if($journal->is_private)
        <p class="mt-4 text-xs text-gray-300 text-center">🔒 Jurnal ini privat</p>
    @endif
</div>
@endsection
