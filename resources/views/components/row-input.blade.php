{{-- Input used inside a repeater row; binds to the Alpine row and builds name="group[i][field]" --}}
@props(['label', 'group', 'field', 'type' => 'text', 'full' => false, 'textarea' => false, 'placeholder' => null])
<label class="block {{ $full ? 'sm:col-span-2' : '' }}">
    <span class="text-sm font-medium text-slate-700">{{ $label }}</span>
    @if ($textarea)
        <textarea rows="3" x-model="row.{{ $field }}" :name="'{{ $group }}[' + i + '][{{ $field }}]'" placeholder="{{ $placeholder }}"
                  class="mt-1 block w-full rounded-xl border-slate-300 bg-white px-3.5 py-2.5 text-sm shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition"></textarea>
    @else
        <input type="{{ $type }}" x-model="row.{{ $field }}" :name="'{{ $group }}[' + i + '][{{ $field }}]'" placeholder="{{ $placeholder }}"
               class="mt-1 block w-full rounded-xl border-slate-300 bg-white px-3.5 py-2.5 text-sm shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition">
    @endif
</label>
