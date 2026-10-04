<x-site-layout title="My Portfolios">
    <section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Page heading and create button --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">My Portfolios</h1>
                <p class="mt-1 text-slate-600">View, edit, or delete the portfolios you have created.</p>
            </div>
            <a href="{{ route('portfolios.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-violet-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:shadow-md hover:brightness-110">
                <x-icon name="plus" class="h-4 w-4" /> Create Portfolio
            </a>
        </div>

        {{-- Search and sort controls (plain GET form so results are shareable) --}}
        <form method="GET" action="{{ route('portfolios.index') }}" class="mt-8 flex flex-col gap-3 sm:flex-row" role="search">
            <div class="relative flex-1">
                <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" />
                <input type="search" name="search" value="{{ $search }}" placeholder="Search by name, email, or title"
                       class="block w-full rounded-xl border-slate-300 bg-white py-2.5 pl-11 pr-4 text-sm shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20" aria-label="Search portfolios">
            </div>
            <select name="sort" onchange="this.form.submit()" aria-label="Sort portfolios"
                    class="rounded-xl border-slate-300 bg-white py-2.5 pl-4 pr-10 text-sm shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20">
                <option value="date_desc" @selected($sort === 'date_desc')>Date: newest first</option>
                <option value="date_asc" @selected($sort === 'date_asc')>Date: oldest first</option>
                <option value="name_asc" @selected($sort === 'name_asc')>Name: A to Z</option>
                <option value="name_desc" @selected($sort === 'name_desc')>Name: Z to A</option>
            </select>
            <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">Search</button>
            @if ($search)
                <a href="{{ route('portfolios.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">Clear</a>
            @endif
        </form>

        {{-- Portfolio cards or an empty state --}}
        @if ($portfolios->count())
            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($portfolios as $portfolio)
                    <article class="flex flex-col rounded-3xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:shadow-md">
                        <div class="flex items-center gap-4">
                            @if ($portfolio->profile_picture_url)
                                <img src="{{ $portfolio->profile_picture_url }}" alt="Profile picture of {{ $portfolio->full_name }}" class="h-16 w-16 rounded-full object-cover ring-2 ring-indigo-100">
                            @else
                                <span class="flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 text-xl font-semibold text-white">{{ $portfolio->initials }}</span>
                            @endif
                            <div class="min-w-0">
                                <h2 class="truncate text-lg font-semibold text-slate-900">{{ $portfolio->full_name }}</h2>
                                <p class="truncate text-sm text-slate-500">{{ $portfolio->professional_title }}</p>
                            </div>
                        </div>

                        <dl class="mt-5 space-y-2 text-sm">
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-slate-500">Email</dt>
                                <dd class="truncate font-medium text-slate-800">{{ $portfolio->email }}</dd>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-slate-500">Template</dt>
                                <dd><x-template-badge :template="$portfolio->selected_template" /></dd>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-slate-500">Created</dt>
                                <dd class="font-medium text-slate-800">{{ $portfolio->created_at->format('M d, Y') }}</dd>
                            </div>
                        </dl>

                        {{-- Card actions --}}
                        <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4">
                            <a href="{{ route('portfolios.show', $portfolio) }}" class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl bg-indigo-600 px-3 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                <x-icon name="eye" class="h-4 w-4" /> View
                            </a>
                            <a href="{{ route('portfolios.edit', $portfolio) }}" class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                <x-icon name="pencil" class="h-4 w-4" /> Edit
                            </a>
                            <form method="POST" action="{{ route('portfolios.destroy', $portfolio) }}" onsubmit="return confirm('Delete this portfolio? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-rose-200 px-3 py-2 text-sm font-semibold text-rose-600 transition hover:bg-rose-50" aria-label="Delete {{ $portfolio->full_name }}">
                                    <x-icon name="trash" class="h-4 w-4" />
                                </button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">{{ $portfolios->links() }}</div>
        @else
            <div class="mt-10 rounded-3xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600"><x-icon name="folder" class="h-7 w-7" /></span>
                @if ($search)
                    <h2 class="mt-4 text-lg font-semibold text-slate-900">No portfolios match "{{ $search }}"</h2>
                    <p class="mt-1 text-slate-600">Try a different name, email, or title.</p>
                @else
                    <h2 class="mt-4 text-lg font-semibold text-slate-900">You have no portfolios yet</h2>
                    <p class="mt-1 text-slate-600">Create your first one and pick a template.</p>
                    <a href="{{ route('portfolios.create') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        <x-icon name="plus" class="h-4 w-4" /> Create Portfolio
                    </a>
                @endif
            </div>
        @endif
    </section>
</x-site-layout>
