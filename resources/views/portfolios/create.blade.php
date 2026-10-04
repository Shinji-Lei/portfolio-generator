<x-site-layout title="Create Portfolio">
    <section class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <a href="{{ route('portfolios.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">&larr; Back to My Portfolios</a>
        <h1 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">Create your portfolio</h1>
        <p class="mt-1 text-slate-600">Fill in your details. Next, you will choose a template.</p>

        <div class="mt-8">
            @include('portfolios._form', [
                'portfolio' => $portfolio,
                'action'    => route('portfolios.store'),
                'method'    => 'POST',
                'resetUrl'  => route('portfolios.create'),
            ])
        </div>
    </section>
</x-site-layout>
