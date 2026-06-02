@extends('layouts.app')
@section('title', 'Tulis Jurnal Baru')

@section('content')
<div class="max-w-3xl mx-auto animate-fade-up">
    {{-- Back & Header Navigation --}}
    <div class="mb-8">
        <a href="{{ route('journal.index') }}"
           class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Kembali Ke Riwayat
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Tulis Jurnal Baru</h1>
        <p class="text-sm font-medium text-slate-500 mt-2">
            🗓️ {{ now()->translatedFormat('l, d F Y') }} — Tuliskan pengalaman dan refleksimu hari ini.
        </p>
    </div>

    {{-- Main Form Card --}}
    <form method="POST" action="{{ route('journal.store') }}" class="card p-6 md:p-8 space-y-8">
        @csrf

        {{-- 1. Mood Picker --}}
        <div>
            <label class="input-label mb-4">
                Bagaimana Perasaanmu Saat Ini? <span class="text-rose-500">*</span>
            </label>
            <x-mood-picker :moods="$moods" :selected="old('mood_id')" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- 2. Judul --}}
            <div>
                <label for="title" class="input-label">
                    Judul Jurnal <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="title" name="title"
                       value="{{ old('title') }}"
                       placeholder="Apa yang paling berkesan hari ini?"
                       class="input">
                @error('title')
                    <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- 3. Tanggal --}}
            <div>
                <label for="journal_date" class="input-label">
                    Tanggal Entri <span class="text-rose-500">*</span>
                </label>
                <input type="date" id="journal_date" name="journal_date"
                       value="{{ old('journal_date', today()->format('Y-m-d')) }}"
                       class="input">
            </div>
        </div>

        {{-- 4. Konten Jurnal --}}
        <div>
            <label for="content" class="input-label">
                Ceritakan Harimu <span class="text-rose-500">*</span>
            </label>
            <textarea id="content" name="content" rows="10"
                      placeholder="Tulis apa saja yang ada di pikiranmu... tentang progres belajarmu, ide baru, atau sekadar keluh kesah. Tidak ada yang salah."
                      class="input resize-none h-64 leading-relaxed">{{ old('content') }}</textarea>
            @error('content')
                <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- 5. Privasi Toggle --}}
        <div class="flex items-center gap-4 bg-slate-50 p-5 rounded-xl border border-slate-200">
            <div class="relative flex items-center h-5">
                <input type="checkbox" id="is_private" name="is_private"
                       {{ old('is_private', true) ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600 cursor-pointer">
            </div>
            <div>
                <label for="is_private" class="text-sm font-bold text-slate-800 cursor-pointer">Jaga Kerahasiaan Jurnal (Privat)</label>
                <p class="text-xs font-medium text-slate-500 mt-1">Jurnal ini hanya akan dapat diakses dan dibaca oleh Anda sendiri.</p>
            </div>
        </div>

        {{-- Form Actions --}}
        <div class="flex items-center gap-4 pt-6 border-t border-slate-100">
            <button type="submit" class="btn btn-primary px-8">
                Simpan Jurnal Baru
            </button>
            <a href="{{ route('journal.index') }}" class="btn btn-secondary">
                Batalkan
            </a>
        </div>
    </form>
</div>
@endsection
