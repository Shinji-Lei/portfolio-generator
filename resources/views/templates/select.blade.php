{{-- Template selection for a saved portfolio. Expects $portfolio and $templates --}}
<x-site-layout title="Choose a template">
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Progress steps --}}
        <ol class="mx-auto mb-10 flex max-w-xl items-center justify-center gap-2 text-sm font-medium" aria-label="Progress">
            <li class="flex items-center gap-2 text-emerald-600"><span class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100">1</span> Information</li>
            <li class="h-px w-8 bg-slate-300"></li>
            <li class="flex items-center gap-2 text-indigo-700"><span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-600 text-white">2</span> Template</li>
            <li class="h-px w-8 bg-slate-300"></li>
            <li class="flex items-center gap-2 text-slate-400"><span class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-100">3</span> Preview</li>
        </ol>

        <div class="text-center">
            <h1 class="text-3xl font-bold tracking-tight text-slate-900">Choose a template for {{ $portfolio->full_name }}</h1>
            <p class="mt-2 text-slate-600">Preview any template with your own data, then select the one you like. You can change it later.</p>
        </div>

        @error('selected_template')
            <div class="mx-auto mt-6 max-w-xl rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800" role="alert">{{ $message }}</div>
        @enderror

        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach ($templates as $key => $template)
                @php $isCurrent = $portfolio->selected_template === $key; @endphp
                <article class="flex flex-col rounded-3xl border bg-white p-4 shadow-sm transition hover:-translate-y-1 hover:shadow-lg {{ $isCurrent ? 'border-indigo-500 ring-2 ring-indigo-500/30' : 'border-slate-200' }}">
                    <x-template-thumb :template="$key" />
                    <div class="flex-1 px-1 pb-2 pt-5">
                        <div class="flex items-center justify-between gap-2">
                            <h2 class="text-lg font-semibold text-slate-900">{{ $template['name'] }}</h2>
                            @if ($isCurrent)<span class="rounded-full bg-indigo-100 px-2.5 py-1 text-xs font-semibold text-indigo-700">Selected</span>@endif
                        </div>
                        <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $template['description'] }}</p>
                    </div>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('portfolios.preview', [$portfolio, $key]) }}" class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            <x-icon name="eye" class="h-4 w-4" /> Preview
                        </a>
                        <form method="POST" action="{{ route('portfolios.template.update', $portfolio) }}" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="selected_template" value="{{ $key }}">
                            <button type="submit" class="w-full rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">Select</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center gap-4 text-sm">
            <a href="{{ route('portfolios.edit', $portfolio) }}" class="font-medium text-indigo-600 hover:text-indigo-800">&larr; Edit information</a>
            <a href="{{ route('portfolios.index') }}" class="font-medium text-slate-500 hover:text-slate-800">My portfolios</a>
        </div>
    </section>
</x-site-layout>
