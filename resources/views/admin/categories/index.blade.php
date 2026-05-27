@extends('layouts.app')

@section('title', 'Kelola Kategori - MindLog EduSmart')

@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-white p-5 card-shadow">
        <div>
            <h1 class="text-2xl font-extrabold">Kategori Pembelajaran</h1>
            <p class="mt-1 text-sm font-medium text-slate-600">Kategori menghubungkan artikel dengan fokus SDGs.</p>
        </div>
        <a href="{{ route('categories.create') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-700">Tambah Kategori</a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @foreach($categories as $category)
            <div class="rounded-lg border border-slate-200 bg-white p-5 card-shadow">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-extrabold">{{ $category->name }}</h2>
                        <p class="mt-2 text-sm font-medium text-slate-600">{{ $category->description }}</p>
                    </div>
                    <span class="rounded-md px-2 py-1 text-xs font-extrabold {{ $category->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                        {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <p class="mt-3 text-xs font-extrabold text-slate-500">{{ $category->sdg_focus }} - {{ $category->articles_count }} artikel</p>
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('categories.edit', $category) }}" class="rounded-md border border-slate-200 px-3 py-1 text-sm font-bold">Edit</a>
                    <form method="POST" action="{{ route('categories.destroy', $category) }}">
                        @csrf
                        @method('DELETE')
                        <button class="rounded-md border border-red-200 px-3 py-1 text-sm font-bold text-red-700">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    {{ $categories->links() }}
</div>
@endsection
