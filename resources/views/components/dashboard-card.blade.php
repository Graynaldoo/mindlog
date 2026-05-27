@props(['title', 'value', 'description' => null])

<div class="rounded-lg border border-slate-200 bg-white p-5 card-shadow">
    <p class="text-sm font-bold text-slate-500">{{ $title }}</p>
    <p class="mt-3 text-3xl font-extrabold text-slate-950">{{ $value }}</p>
    @if($description)
        <p class="mt-2 text-sm font-medium text-slate-500">{{ $description }}</p>
    @endif
</div>
