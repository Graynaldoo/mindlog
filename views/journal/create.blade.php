@extends('layouts.app')
@section('title', 'Tulis Jurnal')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('journal.index') }}"
           class="text-sm text-gray-400 hover:text-gray-700">← Kembali</a>
        <h1 class="font-display text-4xl text-gray-900 mt-2">Tulis Jurnal</h1>
        <p class="text-gray-500 text-sm mt-1">
            {{ now()->translatedFormat('l, d F Y') }}
        </p>
    </div>

    <form method="POST" action="{{ route('journal.store') }}" class="space-y-6">
        @csrf

        {{-- Mood Picker --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Bagaimana perasaanmu hari ini? *
            </label>
            <x-mood-picker :moods="$moods" :selected="old('mood_id')" />
        </div>

        {{-- Judul --}}
        <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                Judul *
            </label>
            <input type="text" id="title" name="title"
                   value="{{ old('title') }}"
                   placeholder="Apa yang paling berkesan hari ini?"
                   class="w-full px-4 py-3 rounded-xl border border-gray-200
                          focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent
                          text-gray-900 placeholder-gray-300 bg-white">
            @error('title')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tanggal --}}
        <div>
            <label for="journal_date" class="block text-sm font-semibold text-gray-700 mb-2">
                Tanggal *
            </label>
            <input type="date" id="journal_date" name="journal_date"
                   value="{{ old('journal_date', today()->format('Y-m-d')) }}"
                   class="w-full px-4 py-3 rounded-xl border border-gray-200
                          focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent
                          bg-white text-gray-900">
        </div>

        {{-- Konten --}}
        <div>
            <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">
                Ceritakan harimu *
            </label>
            <textarea id="content" name="content" rows="8"
                      placeholder="Tulis apa saja yang kamu rasakan hari ini... tidak ada yang benar atau salah."
                      class="w-full px-4 py-3 rounded-xl border border-gray-200
                             focus:outline-none focus:ring-2 focus:ring-violet-400 focus:border-transparent
                             text-gray-900 placeholder-gray-300 bg-white resize-none leading-relaxed">{{ old('content') }}</textarea>
            @error('content')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Privat toggle --}}
        <div class="flex items-center gap-3">
            <input type="checkbox" id="is_private" name="is_private"
                   {{ old('is_private', true) ? 'checked' : '' }}
                   class="w-4 h-4 accent-violet-600 rounded">
            <label for="is_private" class="text-sm text-gray-600">
                🔒 Simpan sebagai jurnal privat
            </label>
        </div>

        {{-- Submit --}}
        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="px-6 py-3 bg-violet-600 hover:bg-violet-700 text-white font-semibold
                           rounded-xl transition-colors">
                Simpan Jurnal ✨
            </button>
            <a href="{{ route('journal.index') }}"
               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium
                      rounded-xl transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
