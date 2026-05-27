@php
    $links = [
        ['label' => 'Dashboard', 'route' => 'dashboard', 'active' => 'dashboard'],
        ['label' => 'Jurnal Harian', 'route' => 'journal.index', 'active' => 'journal.*'],
        ['label' => 'Artikel Edukasi', 'route' => 'articles.index', 'active' => 'articles.index'],
        ['label' => 'Statistik', 'route' => 'statistics.index', 'active' => 'statistics.*'],
    ];
@endphp

<aside class="hidden w-64 shrink-0 lg:block">
    <div class="sticky top-6 space-y-4">
        <div class="rounded-lg border border-slate-200 bg-white p-3 card-shadow">
            <nav class="space-y-1">
                @foreach($links as $link)
                    <a href="{{ route($link['route']) }}"
                       class="block rounded-lg px-3 py-2 text-sm font-bold {{ request()->routeIs($link['active']) ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }}">
                        {{ $link['label'] }}
                    </a>
                @endforeach

                @can('write-articles')
                    <a href="{{ route('articles.manage') }}" class="block rounded-lg px-3 py-2 text-sm font-bold {{ request()->routeIs('articles.manage') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }}">
                        Kelola Artikel
                    </a>
                @endcan

                @can('manage-categories')
                    <a href="{{ route('categories.index') }}" class="block rounded-lg px-3 py-2 text-sm font-bold {{ request()->routeIs('categories.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }}">
                        Kelola Kategori
                    </a>
                @endcan

                @can('manage-users')
                    <a href="{{ route('admin.users.index') }}" class="block rounded-lg px-3 py-2 text-sm font-bold {{ request()->routeIs('admin.users.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50' }}">
                        Kelola User
                    </a>
                @endcan
            </nav>
        </div>
    </div>
</aside>
