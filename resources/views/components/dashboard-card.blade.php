@props(['title', 'value', 'description' => null, 'icon' => null, 'color' => 'indigo'])

@php
    $colorMap = [
        'indigo' => ['bg' => 'bg-indigo-50', 'icon' => 'text-indigo-600', 'ring' => 'ring-indigo-100'],
        'violet' => ['bg' => 'bg-violet-50', 'icon' => 'text-violet-600', 'ring' => 'ring-violet-100'],
        'emerald' => ['bg' => 'bg-emerald-50', 'icon' => 'text-emerald-600', 'ring' => 'ring-emerald-100'],
        'amber' => ['bg' => 'bg-amber-50', 'icon' => 'text-amber-600', 'ring' => 'ring-amber-100'],
        'sky' => ['bg' => 'bg-sky-50', 'icon' => 'text-sky-600', 'ring' => 'ring-sky-100'],
        'rose' => ['bg' => 'bg-rose-50', 'icon' => 'text-rose-600', 'ring' => 'ring-rose-100'],
    ];
    $c = $colorMap[$color] ?? $colorMap['indigo'];
@endphp

<div class="stat-card group" id="stat-{{ Str::slug($title) }}">
    <div class="flex items-start justify-between">
        <div class="flex-1 min-w-0">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ $title }}</p>
            <p class="mt-2 text-3xl font-extrabold text-slate-900 tracking-tight">{{ $value }}</p>
            @if($description)
                <p class="mt-1.5 text-xs font-medium text-slate-400 leading-relaxed line-clamp-2">{{ $description }}</p>
            @endif
        </div>
        @if($icon)
            <div class="w-11 h-11 rounded-xl {{ $c['bg'] }} {{ $c['ring'] }} ring-1 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                {!! $icon !!}
            </div>
        @endif
    </div>
</div>
