{{-- Static information page (privacy, terms, docs, ...). Expects $page with title, intro, sections --}}
<x-site-layout :title="$page['title']">
    <article class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-medium text-indigo-600 hover:text-indigo-800">&larr; Back to home</a>

        <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">{{ $page['title'] }}</h1>
        <p class="mt-4 text-lg leading-8 text-slate-600">{{ $page['intro'] }}</p>

        <div class="mt-12 space-y-8">
            @foreach ($page['sections'] as $heading => $text)
                <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                    <h2 class="text-xl font-semibold text-slate-900">{{ $heading }}</h2>
                    <p class="mt-3 leading-7 text-slate-600">{{ $text }}</p>
                </section>
            @endforeach
        </div>

        <div class="mt-12 rounded-3xl bg-indigo-50 p-6 text-sm text-indigo-900 sm:p-8">
            Questions? Email us at <a href="mailto:{{ config('site.email') }}" class="font-semibold underline">{{ config('site.email') }}</a>.
        </div>
    </article>
</x-site-layout>
