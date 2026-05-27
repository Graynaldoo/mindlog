@extends('layouts.app')

@section('title', $article->title . ' - MindLog EduSmart')

@section('content')
<article class="rounded-lg border border-slate-200 bg-white p-6 card-shadow">
    <p class="text-sm font-extrabold uppercase tracking-wide text-emerald-700">{{ $article->category->name }}</p>
    <h1 class="mt-3 max-w-4xl text-3xl font-extrabold leading-tight">{{ $article->title }}</h1>
    <div class="mt-4 flex flex-wrap gap-3 text-sm font-semibold text-slate-500">
        <span>Oleh {{ $article->author->name }}</span>
        <span>{{ $article->estimated_minutes }} menit baca</span>
        <span>{{ $article->read_count }} kali dibaca</span>
    </div>
    <div class="prose prose-slate mt-8 max-w-none">
        @foreach(preg_split("/\r\n|\n|\r/", $article->content) as $paragraph)
            @if(trim($paragraph) !== '')
                <p class="mb-5 text-base font-medium leading-8 text-slate-700">{{ $paragraph }}</p>
            @endif
        @endforeach
    </div>
</article>
@endsection
