{{-- resources/views/components/mood-picker.blade.php --}}
@props(['moods', 'selected' => null])

<div x-data="{ selected: '{{ $selected }}' }" class="w-full">
    <input type="hidden" name="mood_id" :value="selected">

    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3.5">
        @foreach($moods as $mood)
            <button
                type="button"
                @click="selected = '{{ $mood->id }}'"
                :class="selected == '{{ $mood->id }}'
                    ? 'border-violet-300 bg-violet-50/40 ring-4 ring-violet-500/10 shadow-sm scale-[1.03]'
                    : 'bg-gray-50/50 hover:bg-gray-50 border-gray-100 hover:-translate-y-0.5'"
                class="flex flex-col items-center justify-between gap-2.5 p-4 rounded-2xl border transition-all duration-200 cursor-pointer group text-center h-28">
                <x-mood-icon :score="$mood->score" class="w-8 h-8 group-hover:scale-110" :color="$mood->color" />
                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider group-hover:text-gray-900 transition-colors">{{ $mood->name }}</span>
            </button>
        @endforeach
    </div>

    @error('mood_id')
        <p class="mt-2.5 text-xs font-bold text-red-500">{{ $message }}</p>
    @enderror
</div>
