<x-site-layout title="Templates">
    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900">Choose your style</h1>
            <p class="mt-3 text-slate-600">Three templates, each with a distinct look. Preview them with sample data, then use your own details.</p>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach ($templates as $key => $template)
                <article class="flex flex-col rounded-3xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <x-template-thumb :template="$key" />
                    <div class="flex-1 px-1 pb-2 pt-5">
                        <h2 class="text-lg font-semibold text-slate-900">{{ $template['name'] }}</h2>
                        <p class="mt-1 text-sm leading-relaxed text-slate-600">{{ $template['description'] }}</p>
                    </div>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('templates.demo', $key) }}" class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            <x-icon name="eye" class="h-4 w-4" /> Preview
                        </a>
                        <a href="{{ route('portfolios.create') }}" class="inline-flex flex-1 items-center justify-center rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">Select</a>
                    </div>
                </article>
            @endforeach
        </div>

        <p class="mt-8 text-center text-sm text-slate-500">You pick the final template after entering your information.</p>
    </section>
</x-site-layout>
