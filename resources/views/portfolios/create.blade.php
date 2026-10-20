@php
    // Template picked on the gallery page (kept across validation errors)
    $picked = old('selected_template', request('template'));
    $chosenTemplate = in_array($picked, ['simple', 'modern', 'creative'], true) ? $picked : null;
@endphp
<x-site-layout title="Create Portfolio">
    <section class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <x-steps :current="2" />

        <a href="{{ route('portfolios.index') }}" class="text-sm font-medium text-violet-300 transition hover:text-cyan-300">&larr; Back to My Portfolios</a>
        <h1 class="mt-3 text-3xl font-bold tracking-tight text-white">Create your portfolio</h1>
        <p class="mt-1 text-slate-400">Fill in your details to finish your portfolio.</p>

        @if ($chosenTemplate)
            <div class="mt-3 flex items-center gap-2 text-sm text-slate-400">
                Selected template: <x-template-badge :template="$chosenTemplate" />
                <a href="{{ route('templates.index') }}" class="font-medium text-violet-300 transition hover:text-cyan-300">Change</a>
            </div>
        @endif

        <div class="mt-8">
            @include('portfolios._form', [
                'portfolio'      => $portfolio,
                'action'         => route('portfolios.store'),
                'method'         => 'POST',
                'resetUrl'       => route('portfolios.create', ['template' => $chosenTemplate]),
                'chosenTemplate' => $chosenTemplate,
            ])
        </div>
    </section>
</x-site-layout>