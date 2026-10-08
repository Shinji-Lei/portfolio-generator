{{-- Portfolio preview: action bar on top, selected template below. Expects $portfolio, $template, $isPreview --}}
<x-site-layout :title="$portfolio->full_name">

    {{-- Full-width top strip (extends up behind the navigation bar) filled with the gradient --}}
    <div style="margin-top: -85px; padding-top: 95px;" class="w-full bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-600 pb-4 shadow-xl shadow-violet-900/30">

        {{-- Flash message / status notification styled like your buttons --}}
        {{-- Keep the flash notification above the gradient strip --}}
@push('head')
    <style>
        [role="status"] { position: relative; z-index: 30; }
    </style>
@endpush


        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-3 px-1 py-3.5 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <a href="{{ $isPreview ? route('portfolios.template.edit', $portfolio) : route('portfolios.index') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-white/80 transition hover:text-white">
                        &larr; Back
                    </a>
                    <div class="h-3 w-[1px] bg-white/30"></div>
                    <div class="flex items-center gap-2 text-xs">
                        @if ($isPreview)
                            <span class="font-medium text-amber-200">Preview Mode</span>
                            <x-template-badge :template="$template" />
                        @else
                            <span class="text-white/80">Active Template:</span> <x-template-badge :template="$template" />
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    @if ($isPreview)
                        {{-- Save the previewed template as the portfolio's choice --}}
                        <form method="POST" action="{{ route('portfolios.template.update', $portfolio) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="selected_template" value="{{ $template }}">
                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-emerald-500">Apply Template</button>
                        </form>
                    @else
                        {{-- Edit button: frosted white so it stands out on the gradient --}}
                        <a href="{{ route('portfolios.edit', $portfolio) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-white/30 bg-white/15 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-white/30">
                            <x-icon name="pencil" class="h-3.5 w-3.5" /> Edit
                        </a>

                        {{-- Change Template button: green tint --}}
                        <a href="{{ route('portfolios.template.edit', $portfolio) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-200/40 bg-emerald-500/30 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-emerald-500/50">
                            <x-icon name="layout" class="h-3.5 w-3.5" /> Change Template
                        </a>

                        {{-- Delete button: red tint --}}
                        <form method="POST" action="{{ route('portfolios.destroy', $portfolio) }}" onsubmit="return confirm('Delete this portfolio? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200/40 bg-rose-500/30 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-rose-500/60">
                                <x-icon name="trash" class="h-3.5 w-3.5" /> Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- The chosen template renders the saved data --}}
    @include('templates.' . $template, ['portfolio' => $portfolio])
</x-site-layout>