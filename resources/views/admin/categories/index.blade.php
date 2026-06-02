@extends('layouts.app')
@section('title', 'Kelola Kategori - MindLog EduSmart')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto animate-fade-in">
    {{-- Header --}}
    <div class="card p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-50 border border-amber-100 mb-3">
                <span class="text-[11px] font-bold tracking-wide text-amber-700 uppercase">Manajemen Konten</span>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kategori Artikel</h1>
            <p class="text-sm font-medium text-slate-500 mt-2 max-w-2xl leading-relaxed">
                Kelola kategori dan fokus SDGs untuk mengelompokkan artikel edukasi.
            </p>
        </div>
        <div class="flex-shrink-0 text-center">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 text-white flex items-center justify-center text-2xl font-extrabold shadow-lg shadow-amber-200 mx-auto mb-1.5">
                {{ $categories->total() }}
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total</span>
        </div>
    </div>

    {{-- Categories List --}}
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 stagger-children">
        @foreach($categories as $category)
            <div class="card p-5 hover:border-amber-200 hover:bg-amber-50/20 group transition-all">
                <div class="flex items-start justify-between mb-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase tracking-widest bg-slate-100 text-slate-600 border border-slate-200">
                        {{ $category->sdg_focus }}
                    </span>
                    <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                        <a href="{{ route('categories.edit', $category) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 bg-white rounded-md shadow-sm border border-slate-200" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                        </a>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini? Pastikan tidak ada artikel yang terikat.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 bg-white rounded-md shadow-sm border border-slate-200" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                
                <h3 class="text-base font-extrabold text-slate-900 mb-2 leading-tight">{{ $category->name }}</h3>
                <p class="text-xs font-medium text-slate-500 line-clamp-2 leading-relaxed mb-4">{{ $category->description }}</p>
                
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-slate-400">
                    <span>{{ $category->articles_count }} Artikel</span>
                </div>
            </div>
        @endforeach
    </div>

    @if($categories->hasPages())
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    @endif

    {{-- Add Category Button --}}
    <div class="flex justify-center">
        <a href="{{ route('categories.create') }}"
           id="btn-tambah-kategori"
           class="inline-flex items-center gap-2 px-8 py-3 text-base font-bold text-white rounded-xl transition-all duration-200 hover:-translate-y-0.5"
           style="background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 2px 12px rgba(245,158,11,0.35);">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Tambah Kategori Baru
        </a>
    </div>
</div>
@endsection
