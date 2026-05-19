@extends('layouts.app')
@section('title', 'Tulis Jurnal Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Back & Header Navigation --}}
    <div class="mb-8">
        <a href="{{ route('journal.index') }}"
           class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
            </svg>
            Kembali Ke Riwayat
        </a>
        <h1 class="font-display text-4xl font-bold text-gray-900 mt-3">Tulis Jurnal Baru</h1>
        <p class="text-xs text-gray-400 font-semibold mt-1">
            ✍️ {{ now()->translatedFormat('l, d F Y') }} — Tuliskan apa adanya, tanpa filter.
        </p>
    </div>

    {{-- Main Form Card --}}
    <form method="POST" action="{{ route('journal.store') }}" class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100/70 shadow-sm space-y-7">
        @csrf

        {{-- 1. Mood Picker --}}
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-3.5">
                1. Bagaimana Perasaanmu Saat Ini? *
            </label>
            <x-mood-picker :moods="$moods" :selected="old('mood_id')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
            {{-- 2. Judul --}}
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">
                    2. Judul Jurnal *
                </label>
                <input type="text" id="title" name="title"
                       value="{{ old('title') }}"
                       placeholder="Apa yang paling berkesan hari ini?"
                       class="w-full px-4 py-3.5 rounded-2xl border border-gray-150 focus:border-violet-300 focus:ring-4 focus:ring-violet-500/5 focus:outline-none text-sm text-gray-900 placeholder-gray-300 bg-gray-50/20 font-medium transition-all duration-200">
                @error('title')
                    <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 3. Tanggal --}}
            <div>
                <label for="journal_date" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">
                    3. Tanggal Entri *
                </label>
                <input type="date" id="journal_date" name="journal_date"
                       value="{{ old('journal_date', today()->format('Y-m-d')) }}"
                       class="w-full px-4 py-3.5 rounded-2xl border border-gray-150 focus:border-violet-300 focus:ring-4 focus:ring-violet-500/5 focus:outline-none text-sm text-gray-900 bg-gray-50/20 font-medium transition-all duration-200">
            </div>
        </div>

        {{-- 4. Konten Jurnal --}}
        <div>
            <label for="content" class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">
                4. Ceritakan Harimu *
            </label>
            <textarea id="content" name="content" rows="10"
                      placeholder="Tulis apa saja yang ada di pikiranmu... tentang harimu, impianmu, atau sekadar keluh kesah. Tidak ada yang salah."
                      class="w-full px-5 py-4 rounded-2xl border border-gray-150 focus:border-violet-300 focus:ring-4 focus:ring-violet-500/5 focus:outline-none text-sm text-gray-900 placeholder-gray-300 bg-gray-50/20 resize-none leading-relaxed transition-all duration-200 font-medium h-60">{{ old('content') }}</textarea>
            @error('content')
                <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- 5. Privasi Toggle --}}
        <div class="flex items-center gap-3 bg-gray-50/60 p-4 rounded-2xl border border-gray-100/60">
            <div class="relative flex items-center h-5">
                <input type="checkbox" id="is_private" name="is_private"
                       {{ old('is_private', true) ? 'checked' : '' }}
                       class="w-4 h-4 accent-violet-600 rounded-lg cursor-pointer">
            </div>
            <div class="text-xs">
                <label for="is_private" class="font-bold text-gray-700 cursor-pointer">🔒 Jaga Kerahasiaan Jurnal</label>
                <p class="text-gray-400 font-semibold mt-0.5">Jurnal ini hanya akan dapat diakses dan dibaca olehmu sendiri.</p>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex items-center gap-3.5 pt-4 border-t border-gray-50">
            <button type="submit"
                    class="px-6 py-3.5 bg-violet-600 hover:bg-violet-700 text-white font-bold text-xs uppercase tracking-wider
                           rounded-2xl shadow-lg shadow-violet-100 transition-all duration-200 hover:-translate-y-0.5 cursor-pointer">
                Simpan Jurnal Baru ✨
            </button>
            <a href="{{ route('journal.index') }}"
               class="px-6 py-3.5 bg-gray-50 hover:bg-gray-100 border border-gray-150 text-gray-500 font-bold text-xs uppercase tracking-wider
                      rounded-2xl transition-all duration-200">
                Batalkan
            </a>
        </div>
    </form>
</div>
@endsection
