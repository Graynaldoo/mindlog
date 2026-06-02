@extends('layouts.app')
@php $isEdit = isset($article) && $article->exists; @endphp
@section('title', $isEdit ? 'Edit Artikel' : 'Tulis Artikel Baru')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-up">
    {{-- Back & Header Navigation --}}
    <div class="mb-8">
        <a href="{{ route('articles.manage') }}"
           class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Batal & Kembali
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $isEdit ? 'Edit Artikel Edukasi' : 'Tulis Artikel Edukasi Baru' }}</h1>
    </div>

    <form method="POST" action="{{ $isEdit ? route('articles.update', $article) : route('articles.store') }}" class="card p-6 md:p-10 space-y-8">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-3">
                <label for="title" class="input-label">Judul Artikel <span class="text-rose-500">*</span></label>
                <input type="text" id="title" name="title" class="input text-lg font-bold py-3" value="{{ old('title', $article->title ?? '') }}" required placeholder="Masukkan judul yang menarik...">
                @error('title')<p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="category_id" class="input-label">Kategori <span class="text-rose-500">*</span></label>
                <select id="category_id" name="category_id" class="input cursor-pointer" required>
                    <option value="" disabled selected>Pilih Kategori...</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id ?? '') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="estimated_minutes" class="input-label">Estimasi Waktu Baca (Menit) <span class="text-rose-500">*</span></label>
                <input type="number" id="estimated_minutes" name="estimated_minutes" class="input" value="{{ old('estimated_minutes', $article->estimated_minutes ?? '') }}" min="1" required placeholder="Contoh: 5">
                @error('estimated_minutes')<p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="status" class="input-label">Status Publikasi <span class="text-rose-500">*</span></label>
                <select id="status" name="status" class="input cursor-pointer" required>
                    <option value="draft" @selected(old('status', $article->status ?? '') === 'draft')>Draft (Simpan Sementara)</option>
                    <option value="published" @selected(old('status', $article->status ?? '') === 'published')>Published (Terbitkan)</option>
                </select>
                @error('status')<p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="excerpt" class="input-label">Kutipan Pendek (Excerpt) <span class="text-rose-500">*</span></label>
            <textarea id="excerpt" name="excerpt" class="input h-24 resize-none" required placeholder="Tuliskan ringkasan 1-2 kalimat untuk ditampilkan di kartu artikel...">{{ old('excerpt', $article->excerpt ?? '') }}</textarea>
            @error('excerpt')<p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <div class="flex items-center justify-between mb-2">
                <label for="content" class="input-label mb-0">Isi Konten Artikel <span class="text-rose-500">*</span></label>
                <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded uppercase tracking-widest">Markdown Supported</span>
            </div>
            <textarea id="content" name="content" class="input h-96 font-mono text-sm leading-relaxed" required placeholder="Mulai menulis artikel Anda di sini...">{{ old('content', $article->content ?? '') }}</textarea>
            @error('content')<p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>@enderror
        </div>

        <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-4">
            <a href="{{ route('articles.manage') }}" class="btn btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn btn-primary px-10">
                {{ $isEdit ? 'Simpan Pembaruan' : 'Terbitkan Artikel' }}
            </button>
        </div>
    </form>
</div>
@endsection
