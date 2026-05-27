@props(['label', 'value', 'trend' => null])

<div class="rounded-lg border border-slate-200 bg-white p-4">
    <p class="text-xs font-extrabold uppercase tracking-wide text-slate-500">{{ $label }}</p>
    <div class="mt-2 flex items-end justify-between gap-3">
        <span class="text-2xl font-extrabold">{{ $value }}</span>
        @if($trend !== null)
            <span class="rounded-md bg-emerald-50 px-2 py-1 text-xs font-extrabold text-emerald-700">{{ $trend }}%</span>
        @endif
    </div>
</div>
