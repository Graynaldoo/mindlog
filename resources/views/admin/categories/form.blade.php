@extends('layouts.app')

@section('title', ($category->exists ? 'Edit' : 'Tambah') . ' Kategori - MindLog EduSmart')

@section('content')
<form method="POST" action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}" class="space-y-5 rounded-lg border border-slate-200 bg-white p-6 card-shadow">
    @csrf
    @if($category->exists)
        @method('PUT')
    @endif

    <div>
        <h1 class="text-2xl font-extrabold">{{ $category->exists ? 'Edit Kategori' : 'Tambah Kategori Pembelajaran' }}</h1>
        <p class="mt-1 text-sm font-medium text-slate-600">Gunakan nama yang jelas seperti Literasi Digital atau Kebiasaan Belajar.</p>
    </div>

    <x-form-input name="name" label="Nama Kategori" :value="$category->name" required />
    <x-form-input name="sdg_focus" label="Fokus SDGs" :value="$category->sdg_focus" placeholder="SDG 4 - Quality Education" />

    <label class="block">
        <span class="text-sm font-bold text-slate-700">Deskripsi</span>
        <textarea name="description" rows="4" class="mt-2 w-full rounded-lg border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">{{ old('description', $category->description) }}</textarea>
    </label>

    <label class="inline-flex items-center gap-2 text-sm font-bold text-slate-700">
        <input type="checkbox" name="is_active" value="1" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" @checked(old('is_active', $category->is_active ?? true))>
        Aktif
    </label>

    <button class="rounded-lg bg-emerald-600 px-5 py-3 text-sm font-extrabold text-white hover:bg-emerald-700">Simpan Kategori</button>
</form>
@endsection
