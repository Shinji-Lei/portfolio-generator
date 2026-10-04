{{-- Small colored pill showing which template a portfolio uses --}}
@props(['template'])
@php
    $styles = [
        'simple'   => 'bg-slate-100 text-slate-700 ring-slate-200',
        'modern'   => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
        'creative' => 'bg-fuchsia-50 text-fuchsia-700 ring-fuchsia-200',
    ];
@endphp
<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $styles[$template] ?? $styles['simple'] }}">
    {{ config("portfolio.templates.{$template}.name", ucfirst($template)) }}
</span>
