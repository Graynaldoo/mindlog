{{-- resources/views/components/mood-picker.blade.php --}}
{{-- Usage: <x-mood-picker :moods="$moods" :selected="old('mood_id')" /> --}}

@props(['moods', 'selected' => null])

<div x-data="{ selected: '{{ $selected }}' }">
    <input type="hidden" name="mood_id" :value="selected">

    <div class="grid grid-cols-4 gap-3">
        @foreach($moods as $mood)
            <button
                type="button"
                @click="selected = '{{ $mood->id }}'"
                :class="selected == '{{ $mood->id }}'
                    ? 'ring-2 ring-offset-2 ring-violet-500 scale-105 bg-violet-50'
                    : 'hover:scale-105 bg-gray-50 hover:bg-gray-100'"
                class="flex flex-col items-center gap-1.5 p-3 rounded-2xl border border-gray-100
                       transition-all duration-150 cursor-pointer">
                <span class="text-3xl">{{ $mood->emoji }}</span>
                <span class="text-xs font-medium text-gray-600">{{ $mood->name }}</span>
            </button>
        @endforeach
    </div>

    @error('mood_id')
        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
