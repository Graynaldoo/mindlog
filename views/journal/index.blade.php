@extends('layouts.app')
@section('title', 'Jurnal Saya')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="font-display text-4xl text-gray-900">Jurnal Saya</h1>
        <p class="text-gray-500 text-sm mt-1">{{ $journals->total() }} entri total</p>
    </div>
    <a href="{{ route('journal.create') }}"
       class="flex items-center gap-2 px-4 py-2.5 bg-violet-600 hover:bg-violet-700
              text-white text-sm font-semibold rounded-xl transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Tulis Baru
    </a>
</div>

@if($journals->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        @foreach($journals as $journal)
            <x-journal-card :journal="$journal" />
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center">
        {{ $journals->links() }}
    </div>
@else
    <div class="text-center py-24">
        <p class="text-6xl mb-4">📖</p>
        <h2 class="font-display text-2xl text-gray-700 mb-2">Belum ada jurnal</h2>
        <p class="text-gray-400 text-sm mb-6">
            Mulai dokumentasikan perasaanmu hari ini!
        </p>
        <a href="{{ route('journal.create') }}"
           class="inline-flex px-6 py-3 bg-violet-600 text-white font-semibold rounded-xl hover:bg-violet-700 transition-colors">
            Tulis Jurnal Pertama
        </a>
    </div>
@endif
@endsection
