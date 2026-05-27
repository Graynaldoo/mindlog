@extends('layouts.app')

@section('title', 'Artikel Edukasi - MindLog EduSmart')

@section('content')
<div class="space-y-6">
    <div class="rounded-lg border border-slate-200 bg-white p-6 card-shadow">
        <h1 class="text-2xl font-extrabold">Artikel Edukasi dan Literasi Digital</h1>
        <p class="mt-2 text-sm font-medium text-slate-600">Materi belajar untuk mencerdaskan masyarakat Indonesia melalui pemanfaatan TIK dan dukungan SDGs.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse($articles as $article)
            <a href="{{ route('articles.show', $article->slug) }}" class="rounded-lg border border-slate-200 bg-white p-5 card-shadow hover:border-emerald-300">
                <p class="text-xs font-extrabold uppercase tracking-wide text-emerald-700">{{ $article->category->name }}</p>
                <h2 class="mt-2 text-lg font-extrabold">{{ $article->title }}</h2>
                <p class="mt-3 text-sm font-medium leading-6 text-slate-600">{{ $article->excerpt }}</p>
                <div class="mt-4 flex items-center justify-between text-xs font-bold text-slate-500">
                    <span>{{ $article->estimated_minutes }} menit baca</span>
                    <span>{{ $article->read_count }} dibaca</span>
                </div>
            </a>
        @empty
            <p class="text-sm font-semibold text-slate-500">Belum ada artikel edukasi.</p>
        @endforelse
    </div>

    {{ $articles->links() }}
</div>
@endsection
