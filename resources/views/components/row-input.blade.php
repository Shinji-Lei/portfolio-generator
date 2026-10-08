{{-- Input used inside a repeater row; binds to the Alpine row and builds name="group[i][field]" --}}
@props(['label', 'group', 'field', 'type' => 'text', 'full' => false, 'textarea' => false, 'placeholder' => null])
<label class="block {{ $full ? 'sm:col-span-2' : '' }}">
    <span class="text-sm font-medium text-slate-300">{{ $label }}</span>
    @if ($textarea)
        <textarea rows="3" x-model="row.{{ $field }}" :name="'{{ $group }}[' + i + '][{{ $field }}]'" placeholder="{{ $placeholder }}"
                  class="mt-1 block w-full rounded-xl border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 shadow-sm [color-scheme:dark] placeholder:text-slate-500 focus:border-violet-400 focus:bg-white/10 focus:ring-2 focus:ring-violet-400/30 transition"></textarea>
    @else
        <input type="{{ $type }}" x-model="row.{{ $field }}" :name="'{{ $group }}[' + i + '][{{ $field }}]'" placeholder="{{ $placeholder }}"
               class="mt-1 block w-full rounded-xl border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 shadow-sm [color-scheme:dark] placeholder:text-slate-500 focus:border-violet-400 focus:bg-white/10 focus:ring-2 focus:ring-violet-400/30 transition">
    @endif
</label>