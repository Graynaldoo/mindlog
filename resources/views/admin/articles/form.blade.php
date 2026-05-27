@extends('layouts.app')

@section('title', ($article->exists ? 'Edit' : 'Tambah') . ' Artikel - MindLog EduSmart')

@section('content')
<form method="POST" action="{{ $article->exists ? route('articles.update', $article) : route('articles.store') }}" class="space-y-5 rounded-lg border border-slate-200 bg-white p-6 card-shadow">
    @csrf
    @if($article->exists)
        @method('PUT')
    @endif

    <div>
        <h1 class="text-2xl font-extrabold">{{ $article->exists ? 'Edit Artikel' : 'Tambah Artikel Edukasi' }}</h1>
        <p class="mt-1 text-sm font-medium text-slate-600">Konten diarahkan untuk literasi digital, kebiasaan belajar, dan SDGs.</p>
    </div>

    <x-form-input name="title" label="Judul" :value="$article->title" required />

    <label class="block">
        <span class="text-sm font-bold text-slate-700">Kategori</span>
        <select name="category_id" class="mt-2 w-full rounded-lg border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </label>

    <label class="block">
        <span class="text-sm font-bold text-slate-700">Ringkasan</span>
        <textarea name="excerpt" rows="3" class="mt-2 w-full rounded-lg border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('excerpt', $article->excerpt) }}</textarea>
    </label>

    <label class="block">
        <span class="text-sm font-bold text-slate-700">Konten</span>
        <textarea name="content" rows="12" class="mt-2 w-full rounded-lg border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500" required>{{ old('content', $article->content) }}</textarea>
    </label>

    <div class="grid gap-4 md:grid-cols-2">
        <x-form-input name="estimated_minutes" label="Estimasi Menit Baca" type="number" :value="$article->estimated_minutes ?: 5" min="1" required />
        <label class="block">
            <span class="text-sm font-bold text-slate-700">Status</span>
            <select name="status" class="mt-2 w-full rounded-lg border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                <option value="draft" @selected(old('status', $article->status ?: 'draft') === 'draft')>Draft</option>
                <option value="published" @selected(old('status', $article->status) === 'published')>Published</option>
            </select>
        </label>
    </div>

    <button class="rounded-lg bg-emerald-600 px-5 py-3 text-sm font-extrabold text-white hover:bg-emerald-700">Simpan Artikel</button>
</form>
@endsection
