{{-- Portfolio preview: action bar on top, selected template below. Expects $portfolio, $template, $isPreview --}}
<x-site-layout :title="$portfolio->full_name">

    {{-- Action bar --}}
    <div class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <div class="flex items-center gap-3">
                <a href="{{ $isPreview ? route('portfolios.template.edit', $portfolio) : route('portfolios.index') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-300 px-3.5 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    &larr; Back
                </a>
                <div class="text-sm">
                    @if ($isPreview)
                        <span class="font-semibold text-amber-700">Previewing</span>
                        <x-template-badge :template="$template" />
                        <span class="text-slate-500">(not saved yet)</span>
                    @else
                        <span class="text-slate-500">Template:</span> <x-template-badge :template="$template" />
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
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:brightness-110">Use this template</button>
                    </form>
                @else
                    <a href="{{ route('portfolios.edit', $portfolio) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                        <x-icon name="pencil" class="h-4 w-4" /> Edit
                    </a>
                    <a href="{{ route('portfolios.template.edit', $portfolio) }}" class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        <x-icon name="layout" class="h-4 w-4" /> Change Template
                    </a>
                    <form method="POST" action="{{ route('portfolios.destroy', $portfolio) }}" onsubmit="return confirm('Delete this portfolio? This cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                            <x-icon name="trash" class="h-4 w-4" /> Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    {{-- The chosen template renders the saved data --}}
    @include('templates.' . $template, ['portfolio' => $portfolio])
</x-site-layout>
