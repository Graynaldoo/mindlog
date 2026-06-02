{{-- Mobile Bottom Navigation — MindLog EduSmart --}}
@php
    $mobileLinks = [
        ['label' => 'Beranda', 'route' => 'dashboard', 'active' => 'dashboard',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>'],
        ['label' => 'Jurnal', 'route' => 'journal.index', 'active' => 'journal.*',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>'],
        ['label' => 'Tulis', 'route' => 'journal.create', 'active' => 'journal.create',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>',
         'highlight' => true],
        ['label' => 'Artikel', 'route' => 'articles.index', 'active' => 'articles.*',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>'],
        ['label' => 'Profil', 'route' => 'profile.edit', 'active' => 'profile.*',
         'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>'],
    ];
@endphp

<nav class="mobile-bottom-nav" id="mobile-bottom-nav">
    @foreach($mobileLinks as $link)
        @if(isset($link['highlight']) && $link['highlight'])
            <a href="{{ route($link['route']) }}"
               class="flex items-center justify-center flex-1 py-2" id="mobile-nav-write">
                <div class="w-11 h-11 -mt-5 rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-600 flex items-center justify-center shadow-lg shadow-indigo-300/50">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">{!! $link['icon'] !!}</svg>
                </div>
            </a>
        @else
            <a href="{{ route($link['route']) }}"
               class="mobile-nav-item {{ request()->routeIs($link['active']) ? 'active' : '' }}"
               id="mobile-nav-{{ Str::slug($link['label']) }}">
                <svg fill="none" stroke="currentColor" stroke-width="{{ request()->routeIs($link['active']) ? '2.2' : '1.8' }}" viewBox="0 0 24 24">{!! $link['icon'] !!}</svg>
                <span>{{ $link['label'] }}</span>
            </a>
        @endif
    @endforeach
</nav>
