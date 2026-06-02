@props(['label', 'value', 'trend' => null, 'icon' => null])

<div class="stat-card group" id="stat-{{ Str::slug($label) }}">
    <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ $label }}</p>
    <div class="mt-2 flex items-end justify-between gap-3">
        <span class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $value }}</span>
        @if($trend !== null)
            <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-1 text-xs font-bold
                {{ $trend >= 0 ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-100' : 'bg-rose-50 text-rose-700 ring-1 ring-rose-100' }}">
                @if($trend >= 0)
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941"/>
                    </svg>
                @else
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181"/>
                    </svg>
                @endif
                {{ $trend }}%
            </span>
        @endif
    </div>
</div>
