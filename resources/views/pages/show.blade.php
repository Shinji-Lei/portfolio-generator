{{-- Static information page (privacy, terms, docs, ...). Expects $page with title, intro, sections --}}
<x-site-layout :title="$page['title']">
    <article class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-medium text-indigo-400 hover:text-indigo-300">&larr; Back to home</a>

        <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-white sm:text-5xl">{{ $page['title'] }}</h1>
        <p class="mt-4 text-lg leading-8 text-slate-300">{{ $page['intro'] }}</p>

        <div class="mt-12 space-y-8">
            @foreach ($page['sections'] as $heading => $text)
                {{-- Changed bg-white to bg-slate-900 and adjusted text colors for dark mode --}}
                <section class="rounded-3xl border border-slate-800 bg-slate-900 p-6 shadow-sm sm:p-8">
                    <h2 class="text-xl font-semibold text-white">{{ $heading }}</h2>
                    <p class="mt-3 leading-7 text-slate-300">{{ $text }}</p>
                </section>
            @endforeach
        </div>

        <div class="mt-12 rounded-3xl bg-indigo-950 p-6 text-sm text-indigo-200 sm:p-8 border border-indigo-900">
            Questions? Email us at <a href="mailto:{{ config('site.email') }}" class="font-semibold underline">{{ config('site.email') }}</a>.
        </div>
    </article>
</x-site-layout>