@extends('layouts.app')
@php $isEdit = isset($category) && $category->exists; @endphp
@section('title', $isEdit ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
<div class="max-w-3xl mx-auto animate-fade-up">
    {{-- Back & Header Navigation --}}
    <div class="mb-8">
        <a href="{{ route('categories.index') }}"
           class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-indigo-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
            </svg>
            Batal & Kembali
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $isEdit ? 'Edit Kategori' : 'Kategori Baru' }}</h1>
    </div>

    <form method="POST" action="{{ $isEdit ? route('categories.update', $category) : route('categories.store') }}" class="card p-6 md:p-8 space-y-6">
        @csrf
        @if($isEdit) @method('PUT') @endif

        <div>
            <label for="name" class="input-label">Nama Kategori <span class="text-rose-500">*</span></label>
            <input type="text" id="name" name="name" class="input" value="{{ old('name', $category->name ?? '') }}" required placeholder="Contoh: Pemrograman Web">
            @error('name')<p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="description" class="input-label">Deskripsi <span class="text-rose-500">*</span></label>
            <textarea id="description" name="description" class="input h-32 resize-none" required placeholder="Jelaskan fokus materi pada kategori ini...">{{ old('description', $category->description ?? '') }}</textarea>
            @error('description')<p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="sdg_focus" class="input-label">Fokus SDGs <span class="text-rose-500">*</span></label>
            <input type="text" id="sdg_focus" name="sdg_focus" class="input" value="{{ old('sdg_focus', $category->sdg_focus ?? '') }}" required placeholder="Contoh: SDG 4 - Quality Education">
            @error('sdg_focus')<p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>@enderror
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end">
            <button type="submit" class="btn btn-primary px-8">
                {{ $isEdit ? 'Simpan Perubahan' : 'Buat Kategori' }}
            </button>
        </div>
    </form>
</div>
@endsection
