@extends('layouts.app')
@section('title', 'Edit Jurnal')

@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <a href="{{ route('journal.show', $journal) }}"
           class="text-sm text-gray-400 hover:text-gray-700">← Kembali</a>
        <h1 class="font-display text-4xl text-gray-900 mt-2">Edit Jurnal</h1>
    </div>

    <form method="POST" action="{{ route('journal.update', $journal) }}" class="space-y-6">
        @csrf @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">
                Bagaimana perasaanmu? *
            </label>
            <x-mood-picker :moods="$moods" :selected="old('mood_id', $journal->mood_id)" />
        </div>

        <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Judul *</label>
            <input type="text" id="title" name="title"
                   value="{{ old('title', $journal->title) }}"
                   class="w-full px-4 py-3 rounded-xl border border-gray-200
                          focus:outline-none focus:ring-2 focus:ring-violet-400 bg-white text-gray-900">
            @error('title')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="journal_date" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal *</label>
            <input type="date" id="journal_date" name="journal_date"
                   value="{{ old('journal_date', $journal->journal_date->format('Y-m-d')) }}"
                   class="w-full px-4 py-3 rounded-xl border border-gray-200
                          focus:outline-none focus:ring-2 focus:ring-violet-400 bg-white text-gray-900">
        </div>

        <div>
            <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Isi Jurnal *</label>
            <textarea id="content" name="content" rows="8"
                      class="w-full px-4 py-3 rounded-xl border border-gray-200
                             focus:outline-none focus:ring-2 focus:ring-violet-400 bg-white
                             text-gray-900 resize-none leading-relaxed">{{ old('content', $journal->content) }}</textarea>
            @error('content')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" id="is_private" name="is_private"
                   {{ old('is_private', $journal->is_private) ? 'checked' : '' }}
                   class="w-4 h-4 accent-violet-600 rounded">
            <label for="is_private" class="text-sm text-gray-600">🔒 Simpan sebagai privat</label>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                    class="px-6 py-3 bg-violet-600 hover:bg-violet-700 text-white font-semibold rounded-xl transition-colors">
                Simpan Perubahan
            </button>
            <a href="{{ route('journal.show', $journal) }}"
               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
