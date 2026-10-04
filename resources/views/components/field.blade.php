{{-- Labeled text input or textarea with old-input and inline error support --}}
@props(['label', 'name', 'type' => 'text', 'value' => null, 'required' => false, 'hint' => null, 'textarea' => false, 'rows' => 4, 'placeholder' => null])
@php
    // Convert names like social_links[github] into the dotted key used by old() and $errors
    $key = trim(str_replace(['[', ']'], ['.', ''], $name), '.');
    $id = 'field_' . str_replace('.', '_', $key);
    $border = $errors->has($key) ? 'border-rose-400' : 'border-slate-300';
    $classes = "mt-1 block w-full rounded-xl {$border} bg-white px-3.5 py-2.5 text-sm shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition";
@endphp
<div {{ $attributes->only('class') }}>
    <label for="{{ $id }}" class="block text-sm font-medium text-slate-700">
        {{ $label }}
        @if ($required)<span class="text-rose-500" aria-hidden="true">*</span>@endif
    </label>

    @if ($textarea)
        <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" class="{{ $classes }}">{{ old($key, $value) }}</textarea>
    @else
        <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($key, $value) }}" placeholder="{{ $placeholder }}" class="{{ $classes }}">
    @endif

    @if ($hint)<p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>@endif
    @error($key)<p class="mt-1 text-sm text-rose-600">{{ $message }}</p>@enderror
</div>
