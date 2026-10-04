{{-- Public demo of one template using sample data. Expects $portfolio (unsaved) and $template --}}
<x-site-layout :title="ucfirst($template) . ' template demo'">
    <div class="border-b border-amber-200 bg-amber-50">
        <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <p class="text-sm text-amber-900">
                <span class="font-semibold">Demo:</span> the <x-template-badge :template="$template" /> template with sample data.
            </p>
            <div class="flex gap-2">
                <a href="{{ route('templates.index') }}" class="rounded-xl border border-amber-300 bg-white px-4 py-2 text-sm font-semibold text-amber-900 transition hover:bg-amber-100">All templates</a>
                <a href="{{ route('portfolios.create') }}" class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">Create my portfolio</a>
            </div>
        </div>
    </div>

    @include('templates.' . $template, ['portfolio' => $portfolio])
</x-site-layout>
