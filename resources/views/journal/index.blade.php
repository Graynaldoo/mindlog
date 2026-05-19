@extends('layouts.app')
@section('title', 'Jurnal Saya')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <span class="text-xs font-bold uppercase tracking-wider text-violet-500">Arsip Emosi & Refleksi</span>
        <h1 class="font-display text-4xl font-bold text-gray-900 mt-0.5">Jurnal Saya</h1>
        <p class="text-xs text-gray-400 font-semibold mt-1">📚 Menampilkan {{ $journals->total() }} entri yang telah terdokumentasikan.</p>
    </div>
    
    <a href="{{ route('journal.create') }}"
       class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-violet-600 hover:bg-violet-700
              text-white text-xs font-bold rounded-2xl shadow-lg shadow-violet-100 transition-all duration-200 hover:-translate-y-0.5 self-start sm:self-auto">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tulis Jurnal Baru
    </a>
</div>

@if($journals->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
        @foreach($journals as $journal)
            <x-journal-card :journal="$journal" />
        @endforeach
    </div>

    {{-- Premium Pagination --}}
    <div class="flex justify-center mt-10">
        {{ $journals->links() }}
    </div>
@else
    <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm max-w-xl mx-auto">
        <span class="text-6xl block mb-4">📖</span>
        <h2 class="font-display text-2xl font-bold text-gray-800 mb-2">Belum Ada Lembaran Cerita</h2>
        <p class="text-xs text-gray-400 font-medium max-w-md mx-auto mb-6 px-6">
            Mulai rekam emosi, keluh kesah, atau momen bahagia yang kamu lalui hari ini untuk memperkuat kesadaran mentalmu.
        </p>
        <a href="{{ route('journal.create') }}"
           class="inline-flex px-5 py-3 bg-violet-600 hover:bg-violet-700 text-white text-xs font-bold rounded-2xl shadow-lg shadow-violet-100 transition-all duration-200">
            Mulai Tulis Jurnal Pertama
        </a>
    </div>
@endif
@endsection
