@extends('layouts.app')

@section('title', 'Kelola Artikel - MindLog EduSmart')

@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-white p-5 card-shadow">
        <div>
            <h1 class="text-2xl font-extrabold">Kelola Artikel Edukasi</h1>
            <p class="mt-1 text-sm font-medium text-slate-600">Admin dapat mengelola semua artikel, educator dapat mengedit artikel miliknya.</p>
        </div>
        <a href="{{ route('articles.create') }}" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white hover:bg-emerald-700">Tambah Artikel</a>
    </div>

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white card-shadow">
        <table class="w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-extrabold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Dibaca</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($articles as $article)
                    <tr>
                        <td class="px-4 py-3 font-bold">{{ $article->title }}</td>
                        <td class="px-4 py-3">{{ $article->category->name }}</td>
                        <td class="px-4 py-3">{{ ucfirst($article->status) }}</td>
                        <td class="px-4 py-3">{{ $article->read_count }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-2">
                                @can('update', $article)
                                    <a href="{{ route('articles.edit', $article) }}" class="rounded-md border border-slate-200 px-3 py-1 font-bold text-slate-700">Edit</a>
                                @endcan
                                @can('delete', $article)
                                    <form method="POST" action="{{ route('articles.destroy', $article) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-md border border-red-200 px-3 py-1 font-bold text-red-700">Hapus</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $articles->links() }}
</div>
@endsection
