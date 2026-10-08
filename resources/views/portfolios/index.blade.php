<x-site-layout title="My Portfolios">

    {{-- Page-only styles (plain CSS, so no Tailwind rebuild is needed) --}}
    @push('head')
        <style>
            /* Dark gradient page background. It ends on the footer's color so the two blend together. */
            html body.bg-slate-50 {
                background:
                    radial-gradient(60rem 28rem at 12% -8%, rgba(99, 102, 241, 0.38), transparent 62%),
                    radial-gradient(50rem 28rem at 92% 6%, rgba(168, 85, 247, 0.26), transparent 60%),
                    linear-gradient(180deg, #070b1a 0%, #0b1022 55%, #0f172a 100%);
                background-attachment: fixed;
            }

            /* Page body fills the whole screen, so the footer only appears after you scroll */
            .pf-page { min-height: 100vh; min-height: 100dvh; }

            .pf-title { color: #ffffff; }
            .pf-lead  { color: #cbd5e1; }

            /* Search box and sort dropdown */
            form .pf-input {
                background-color: rgba(255, 255, 255, 0.07);
                color: #ffffff;
                border: 1px solid rgba(255, 255, 255, 0.22);
                box-shadow: none;
            }
            form .pf-input::placeholder { color: #94a3b8; }
            form .pf-input:focus {
                outline: none;
                border-color: #818cf8;
                box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.3);
            }
            form select.pf-input {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23cbd5e1' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
                background-position: right 0.5rem center;
                background-repeat: no-repeat;
                background-size: 1.5em 1.5em;
            }
            form select.pf-input option { background: #0f172a; color: #ffffff; }

            /* Buttons */
            .pf-btn-solid {
                color: #ffffff;
                background: linear-gradient(90deg, #4f46e5, #7c3aed);
                box-shadow: 0 6px 18px rgba(99, 102, 241, 0.35);
                transition: filter 0.15s ease, box-shadow 0.15s ease;
            }
            .pf-btn-solid:hover { filter: brightness(1.12); box-shadow: 0 8px 24px rgba(124, 58, 237, 0.45); }
            .pf-btn-light {
                color: #0f172a;
                background: #ffffff;
                transition: background-color 0.15s ease;
            }
            .pf-btn-light:hover { background: #e2e8f0; }
            .pf-btn-ghost {
                color: #ffffff;
                background: transparent;
                border: 1px solid rgba(255, 255, 255, 0.35);
                transition: background-color 0.15s ease, border-color 0.15s ease;
            }
            .pf-btn-ghost:hover { background: rgba(255, 255, 255, 0.12); border-color: rgba(255, 255, 255, 0.6); }
            .pf-btn-danger {
                color: #fb7185;
                background: transparent;
                border: 1px solid rgba(251, 113, 133, 0.5);
                transition: background-color 0.15s ease, border-color 0.15s ease;
            }
            .pf-btn-danger:hover { background: rgba(244, 63, 94, 0.15); border-color: rgba(251, 113, 133, 0.85); }
            .pf-btn-solid:focus-visible,
            .pf-btn-light:focus-visible,
            .pf-btn-ghost:focus-visible,
            .pf-btn-danger:focus-visible { outline: 2px solid #a5b4fc; outline-offset: 2px; }

            /* Dark glass cards */
            .pf-card {
                background: rgba(255, 255, 255, 0.05);
                -webkit-backdrop-filter: blur(12px);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.12);
                box-shadow: 0 10px 30px rgba(2, 6, 23, 0.45);
                transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
            }
            .pf-card:hover {
                transform: translateY(-4px);
                border-color: rgba(129, 140, 248, 0.65);
                box-shadow: 0 16px 40px rgba(2, 6, 23, 0.55), 0 0 0 1px rgba(129, 140, 248, 0.25);
            }
            .pf-name { color: #ffffff; }
            .pf-sub  { color: #cbd5e1; }
            .pf-card dt { color: #94a3b8; }
            .pf-card dd { color: #ffffff; }
            .pf-actions { border-top: 1px solid rgba(255, 255, 255, 0.12); }

            /* Empty state */
            .pf-empty {
                background: rgba(255, 255, 255, 0.04);
                border: 1px dashed rgba(255, 255, 255, 0.28);
            }
            .pf-empty h2 { color: #ffffff; }
            .pf-empty p  { color: #cbd5e1; }
            .pf-empty-icon { background: rgba(99, 102, 241, 0.2); color: #a5b4fc; }

            /* Page numbers and the "Showing x to y" text stay readable on dark */
            .pf-pagination p,
            .pf-pagination span { color: #cbd5e1; }

            @media (prefers-reduced-motion: reduce) {
                .pf-card { transition: none; }
                .pf-card:hover { transform: none; }
            }
        </style>
    @endpush

    <section class="pf-page mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Page heading and create button --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="pf-title text-3xl font-bold tracking-tight">My Portfolios</h1>
                <p class="pf-lead mt-1">View, edit, or delete the portfolios you have created.</p>
            </div>
            <a href="{{ route('portfolios.create') }}" class="pf-btn-solid inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold">
                <x-icon name="plus" class="h-4 w-4" /> Create Portfolio
            </a>
        </div>

        {{-- Search and sort controls (plain GET form so results are shareable) --}}
        <form method="GET" action="{{ route('portfolios.index') }}" class="mt-8 flex flex-col gap-3 sm:flex-row" role="search">
            <div class="relative flex-1">
                <x-icon name="search" class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" />
                <input type="search" name="search" value="{{ $search }}" placeholder="Search by name, email, or title"
                       class="pf-input block w-full rounded-xl py-2.5 pl-11 pr-4 text-sm" aria-label="Search portfolios">
            </div>
            <select name="sort" onchange="this.form.submit()" aria-label="Sort portfolios"
                    class="pf-input rounded-xl py-2.5 pl-4 pr-10 text-sm">
                <option value="date_desc" @selected($sort === 'date_desc')>Date: newest first</option>
                <option value="date_asc" @selected($sort === 'date_asc')>Date: oldest first</option>
                <option value="name_asc" @selected($sort === 'name_asc')>Name: A to Z</option>
                <option value="name_desc" @selected($sort === 'name_desc')>Name: Z to A</option>
            </select>
            <button type="submit" class="pf-btn-light rounded-xl px-5 py-2.5 text-sm font-semibold">Search</button>
            @if ($search)
                <a href="{{ route('portfolios.index') }}" class="pf-btn-ghost inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-medium">Clear</a>
            @endif
        </form>

        {{-- Portfolio cards or an empty state --}}
        @if ($portfolios->count())
            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($portfolios as $portfolio)
                    <article class="pf-card flex flex-col rounded-3xl p-5">
                        <div class="flex items-center gap-4">
                            @if ($portfolio->profile_picture_url)
                                <img src="{{ $portfolio->profile_picture_url }}" alt="Profile picture of {{ $portfolio->full_name }}" class="h-16 w-16 rounded-full object-cover ring-2 ring-indigo-100">
                            @else
                                <span class="flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-violet-500 text-xl font-semibold text-white">{{ $portfolio->initials }}</span>
                            @endif
                            <div class="min-w-0">
                                <h2 class="pf-name truncate text-lg font-semibold">{{ $portfolio->full_name }}</h2>
                                <p class="pf-sub truncate text-sm">{{ $portfolio->professional_title }}</p>
                            </div>
                        </div>

                        <dl class="mt-5 space-y-2 text-sm">
                            <div class="flex items-center justify-between gap-3">
                                <dt>Email</dt>
                                <dd class="truncate font-medium">{{ $portfolio->email }}</dd>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <dt>Template</dt>
                                <dd><x-template-badge :template="$portfolio->selected_template" /></dd>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <dt>Created</dt>
                                <dd class="font-medium">{{ $portfolio->created_at->format('M d, Y') }}</dd>
                            </div>
                        </dl>

                        {{-- Card actions --}}
                        <div class="pf-actions mt-5 flex items-center gap-2 pt-4">
                            <a href="{{ route('portfolios.show', $portfolio) }}" class="pf-btn-solid inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-sm font-semibold">
                                <x-icon name="eye" class="h-4 w-4" /> View
                            </a>
                            <a href="{{ route('portfolios.edit', $portfolio) }}" class="pf-btn-ghost inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-sm font-semibold">
                                <x-icon name="pencil" class="h-4 w-4" /> Edit
                            </a>
                            <form method="POST" action="{{ route('portfolios.destroy', $portfolio) }}" onsubmit="return confirm('Delete this portfolio? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="pf-btn-danger inline-flex items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-sm font-semibold" aria-label="Delete {{ $portfolio->full_name }}">
                                    <x-icon name="trash" class="h-4 w-4" />
                                </button>
                            </form>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pf-pagination mt-8">{{ $portfolios->links() }}</div>
        @else
            <div class="pf-empty mt-10 rounded-3xl px-6 py-16 text-center">
                <span class="pf-empty-icon mx-auto flex h-14 w-14 items-center justify-center rounded-2xl"><x-icon name="folder" class="h-7 w-7" /></span>
                @if ($search)
                    <h2 class="mt-4 text-lg font-semibold">No portfolios match "{{ $search }}"</h2>
                    <p class="mt-1">Try a different name, email, or title.</p>
                @else
                    <h2 class="mt-4 text-lg font-semibold">You have no portfolios yet</h2>
                    <p class="mt-1">Create your first one and pick a template.</p>
                    <a href="{{ route('portfolios.create') }}" class="pf-btn-solid mt-6 inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold">
                        <x-icon name="plus" class="h-4 w-4" /> Create Portfolio
                    </a>
                @endif
            </div>
        @endif
    </section>
</x-site-layout>