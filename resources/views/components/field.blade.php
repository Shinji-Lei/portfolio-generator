{{-- Labeled text input or textarea with old-input and inline error support --}}
@props(['label', 'name', 'type' => 'text', 'value' => null, 'required' => false, 'hint' => null, 'textarea' => false, 'rows' => 4, 'placeholder' => null])
@php
    // Convert names like social_links[github] into the dotted key used by old() and $errors
    $key = trim(str_replace(['[', ']'], ['.', ''], $name), '.');
    $id = 'field_' . str_replace('.', '_', $key);
    $border = $errors->has($key) ? 'border-rose-400/70' : 'border-white/10';
    $classes = "mt-1 block w-full rounded-xl {$border} bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 shadow-sm [color-scheme:dark] placeholder:text-slate-500 focus:border-violet-400 focus:bg-white/10 focus:ring-2 focus:ring-violet-400/30 transition";
@endphp
<div {{ $attributes->only('class') }}>
    <label for="{{ $id }}" class="block text-sm font-medium text-slate-300">
        {{ $label }}
        @if ($required)<span class="text-rose-400" aria-hidden="true">*</span>@endif
    </label>

    @if ($textarea)
        <textarea id="{{ $id }}" name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" class="{{ $classes }}">{{ old($key, $value) }}</textarea>
    @else
        <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($key, $value) }}" placeholder="{{ $placeholder }}" class="{{ $classes }}">
    @endif

    @if ($hint)<p class="mt-1 text-xs text-slate-500">{{ $hint }}</p>@endif
    @error($key)<p class="mt-1 text-sm text-rose-400">{{ $message }}</p>@enderror
</div>