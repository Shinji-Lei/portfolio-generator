<x-site-layout title="Build your portfolio">

    {{-- Hero section --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-indigo-50 via-white to-slate-50"></div>
        <div class="absolute -top-24 left-1/2 -z-10 h-72 w-72 -translate-x-1/2 rounded-full bg-violet-300/30 blur-3xl"></div>

        <div class="mx-auto max-w-4xl px-4 py-20 text-center sm:px-6 sm:py-28">
            <x-logo class="mb-6" />
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 sm:text-6xl">
                Turn your story into a
                <span class="bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-600 bg-clip-text text-transparent">stunning portfolio</span>
            </h1>
            <p class="mx-auto mt-5 max-w-2xl text-lg text-slate-600">
                Enter your details once, pick one of three professionally designed templates, and preview your finished portfolio in seconds.
            </p>
            <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <a href="{{ route('portfolios.create') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 px-7 py-3.5 text-base font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:-translate-y-0.5 hover:shadow-xl sm:w-auto">
                    Create Portfolio <x-icon name="arrow-right" class="h-5 w-5" />
                </a>
                <a href="{{ route('templates.index') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-slate-300 bg-white px-7 py-3.5 text-base font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:border-slate-400 sm:w-auto">
                    <x-icon name="eye" class="h-5 w-5" /> View Templates
                </a>
            </div>
        </div>
    </section>

    {{-- Features section --}}
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-slate-900">Everything you need, nothing you don't</h2>
            <p class="mt-3 text-slate-600">A simple flow from your details to a finished portfolio.</p>
        </div>

        @php
            $features = [
                ['icon' => 'document', 'title' => 'One guided form', 'text' => 'Add your education, skills, projects, experience, and links in a single organized form.'],
                ['icon' => 'layout', 'title' => 'Three templates', 'text' => 'Choose between Simple, Modern, and Creative, each with its own distinct look.'],
                ['icon' => 'eye', 'title' => 'Instant preview', 'text' => 'See your portfolio in any template before you decide, and switch whenever you like.'],
                ['icon' => 'pencil', 'title' => 'Edit anytime', 'text' => 'Update your details or delete a portfolio whenever your career changes.'],
                ['icon' => 'cloud', 'title' => 'Saved online', 'text' => 'Your data lives in an online database, so it is still there after you refresh.'],
                ['icon' => 'shield', 'title' => 'Private accounts', 'text' => 'Sign in to manage your work. Only you can edit or delete your portfolios.'],
            ];
        @endphp

        <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($features as $feature)
                <div class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 transition group-hover:bg-indigo-600 group-hover:text-white">
                        <x-icon :name="$feature['icon']" class="h-6 w-6" />
                    </span>
                    <h3 class="mt-4 text-lg font-semibold text-slate-900">{{ $feature['title'] }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $feature['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Template teaser --}}
    <section class="bg-white py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900">Three looks, one portfolio</h2>
                <p class="mt-3 text-slate-600">Same information, three completely different styles.</p>
            </div>
            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach ($templates as $key => $template)
                    <a href="{{ route('templates.demo', $key) }}" class="group block rounded-3xl border border-slate-200 bg-slate-50 p-4 transition hover:-translate-y-1 hover:shadow-lg">
                        <x-template-thumb :template="$key" class="transition group-hover:scale-[1.02]" />
                        <div class="px-1 pb-1 pt-4">
                            <h3 class="font-semibold text-slate-900">{{ $template['name'] }}</h3>
                            <p class="mt-1 text-sm text-slate-600">{{ $template['description'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Closing call to action --}}
    <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-gradient-to-r from-indigo-600 via-violet-600 to-fuchsia-600 px-6 py-12 text-center text-white shadow-xl">
            <h2 class="text-3xl font-bold">Ready to show your work?</h2>
            <p class="mx-auto mt-3 max-w-xl text-indigo-100">Create your portfolio in minutes and keep it updated as you grow.</p>
            <a href="{{ route('portfolios.create') }}" class="mt-7 inline-flex items-center gap-2 rounded-2xl bg-white px-7 py-3.5 font-semibold text-indigo-700 shadow transition hover:-translate-y-0.5 hover:shadow-lg">
                Create Portfolio <x-icon name="arrow-right" class="h-5 w-5" />
            </a>
        </div>
    </section>
</x-site-layout>
