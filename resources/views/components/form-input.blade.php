@props(['name', 'label', 'type' => 'text', 'value' => null])

<label class="block">
    <span class="text-sm font-bold text-slate-700">{{ $label }}</span>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => 'mt-2 w-full rounded-lg border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500']) }}
    >
</label>
