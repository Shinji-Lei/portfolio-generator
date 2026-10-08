<x-site-layout title="Edit Portfolio">
    <section class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <a href="{{ route('portfolios.show', $portfolio) }}" class="text-sm font-medium text-violet-300 transition hover:text-cyan-300">&larr; Back to preview</a>
        <h1 class="mt-3 text-3xl font-bold tracking-tight text-white">Edit portfolio</h1>
        <p class="mt-1 text-slate-400">Update your details and save the changes.</p>

        <div class="mt-8">
            @include('portfolios._form', [
                'portfolio' => $portfolio,
                'action'    => route('portfolios.update', $portfolio),
                'method'    => 'PUT',
                'resetUrl'  => route('portfolios.edit', $portfolio),
            ])
        </div>
    </section>
</x-site-layout>