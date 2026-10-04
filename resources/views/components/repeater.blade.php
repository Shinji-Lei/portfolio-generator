{{-- Alpine-powered list of repeatable rows; the slot holds the fields for one row --}}
@props(['title', 'rows', 'blank', 'addLabel'])
<div x-data="repeater(@js($rows), @js($blank))" class="space-y-4">
    <template x-for="(row, i) in rows" :key="row._k">
        <div class="rounded-2xl border border-slate-200 bg-slate-50/60 p-4 sm:p-5">
            <div class="mb-3 flex items-center justify-between">
                <p class="text-sm font-semibold text-slate-700">{{ $title }} <span x-text="i + 1"></span></p>
                <button type="button" @click="remove(i)" class="inline-flex items-center gap-1 rounded-lg px-2 py-1 text-xs font-medium text-rose-600 transition hover:bg-rose-50">
                    <x-icon name="trash" class="h-4 w-4" /> Remove
                </button>
            </div>
            <div class="grid gap-4 sm:grid-cols-2">{{ $slot }}</div>
        </div>
    </template>

    <button type="button" @click="add()" class="inline-flex items-center gap-2 rounded-xl border border-dashed border-indigo-300 px-4 py-2 text-sm font-medium text-indigo-600 transition hover:bg-indigo-50">
        <x-icon name="plus" class="h-4 w-4" /> {{ $addLabel }}
    </button>
</div>
