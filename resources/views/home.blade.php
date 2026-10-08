<x-site-layout title="Build your portfolio">

    {{-- Spline loader + homepage-only styles (plain CSS, so no Tailwind rebuild is needed) --}}
    @push('head')
        <script type="module" src="https://cdn.spline.design/@splinetool/viewer@2.0.75/build/spline-viewer.js"></script>
        <style>
            /* Dark base so there is no white flash while the 3D scene loads */
            html body.bg-slate-50 { background-color: #03050b; }

            /* 3D scene sits at the top of the page and scrolls away with the content */
            .home-spline-bg {
                position: absolute;      /* was: fixed */
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                height: 100dvh;
                z-index: -1;
                pointer-events: none;    /* never blocks clicks, links, or scrolling */
                /* soft fade so the scene melts into the dark background below it */
                -webkit-mask-image: linear-gradient(to bottom, #000 82%, transparent 100%);
                mask-image: linear-gradient(to bottom, #000 82%, transparent 100%);
            }

            /* Hero: the heading and paragraph are drawn inside the Spline scene.
               This block only holds the two buttons, placed under that paragraph. */
            .home-hero {
                --home-header-h: 4.5rem;  /* approximate height of the sticky navbar */
                --home-buttons-y: 70;     /* buttons' top edge as % of screen height: raise/lower to line up under the paragraph */
                position: relative;
                min-height: 32rem;
                height: calc(100vh - var(--home-header-h));
                height: calc(100dvh - var(--home-header-h));
            }
            .home-hero-actions {
                position: absolute;
                left: 0;
                right: 0;
                top: calc(var(--home-buttons-y) * 1vh - var(--home-header-h));
                padding: 0 1rem;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
            }
            @media (min-width: 640px) { .home-hero-actions { flex-direction: row; } }

            /* Hero buttons: fade + zoom in on page load */

/* Hero buttons: slow fade + zoom in on page load (both at the same time) */
@keyframes home-fade-zoom {
    from { opacity: 0; transform: scale(0.8); }
    to   { opacity: 1; transform: scale(1); }
}
.home-hero-actions > a {
    /* "backwards" (not "both") so the hover lift still works after the animation ends */
    animation: home-fade-zoom 1.6s cubic-bezier(0.16, 1, 0.3, 1) 1.5s backwards;
}

@media (prefers-reduced-motion: reduce) {
    .home-hero-actions > a { animation: none; }
}

            /* Real heading text for screen readers and search engines (the visible copy lives in the scene) */
            .home-sr-only {
                position: absolute;
                width: 1px;
                height: 1px;
                margin: -1px;
                padding: 0;
                overflow: hidden;
                clip: rect(0, 0, 0, 0);
                white-space: nowrap;
                border: 0;
            }

            /* Everything below the hero: aesthetic dark background */
            .home-after {
                position: relative;
                background:
                    radial-gradient(60rem 30rem at 15% 0%,   rgba(99, 102, 241, 0.18), transparent 60%),
                    radial-gradient(50rem 30rem at 85% 40%,  rgba(139, 92, 246, 0.14), transparent 60%),
                    radial-gradient(40rem 25rem at 20% 100%, rgba(217, 70, 239, 0.10), transparent 60%),
                    linear-gradient(rgba(255, 255, 255, 0.025) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255, 255, 255, 0.025) 1px, transparent 1px),
                    linear-gradient(180deg, #03050b 0%, #070a14 50%, #04060d 100%);
                background-size: auto, auto, auto, 48px 48px, 48px 48px, auto;
                border-top: 0;
            }
            .home-after .home-head h2 { color: #ffffff; }
            .home-after .home-head p { color: #cbd5e1; }

            /* Dark glass cards (feature cards and template cards) */
            .home-card {
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.10);
                -webkit-backdrop-filter: blur(14px);
                backdrop-filter: blur(14px);
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08), 0 10px 30px rgba(0, 0, 0, 0.35);
                transition: transform .2s ease, border-color .2s ease, background .2s ease, box-shadow .2s ease;
            }
            .home-card:hover {
                background: rgba(255, 255, 255, 0.08);
                border-color: rgba(129, 140, 248, 0.45);
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.12), 0 14px 40px rgba(99, 102, 241, 0.20);
            }
            .home-card h3 { color: #ffffff; }
            .home-card p { color: #94a3b8; }
            .home-card-icon {
                background: rgba(99, 102, 241, 0.15);
                color: #a5b4fc;
                border: 1px solid rgba(165, 180, 252, 0.20);
                transition: background .2s ease, color .2s ease;
            }
            .home-card:hover .home-card-icon { background: #4f46e5; color: #ffffff; }
        </style>
    @endpush

    {{-- The 3D background itself (rendered right after <body> by the layout) --}}
    @push('background')
        <spline-viewer class="home-spline-bg" url="https://prod.spline.design/aaG0G-Hl1SfYi41p/scene.splinecode" aria-hidden="true"></spline-viewer>
    @endpush

    {{-- Hero section --}}
    <section class="home-hero" aria-labelledby="home-hero-title">
        <h1 id="home-hero-title" class="home-sr-only">Turn your story into a stunning portfolio</h1>
        <p class="home-sr-only">Enter your details once, pick one of three professionally designed templates, and preview your finished portfolio in seconds.</p>

        <div class="home-hero-actions">
            <a href="{{ route('portfolios.create') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-600 to-violet-600 px-7 py-3.5 text-base font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:-translate-y-0.5 hover:shadow-xl sm:w-auto">
                Create Portfolio <x-icon name="arrow-right" class="h-5 w-5" />
            </a>
            <a href="{{ route('templates.index') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-slate-300 bg-white px-7 py-3.5 text-base font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:border-slate-400 sm:w-auto">
                <x-icon name="eye" class="h-5 w-5" /> View Templates
            </a>
        </div>
    </section>

    <div class="home-after">

        {{-- Features section --}}
        <section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="home-head mx-auto max-w-2xl text-center">
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
                    <div class="home-card group rounded-3xl p-6 hover:-translate-y-1">
                        <span class="home-card-icon flex h-11 w-11 items-center justify-center rounded-2xl">
                            <x-icon :name="$feature['icon']" class="h-6 w-6" />
                        </span>
                        <h3 class="mt-4 text-lg font-semibold">{{ $feature['title'] }}</h3>
                        <p class="mt-2 text-sm leading-relaxed">{{ $feature['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Template teaser --}}
        <section class="py-16">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="home-head mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900">Three looks, one portfolio</h2>
                    <p class="mt-3 text-slate-600">Same information, three completely different styles.</p>
                </div>
                <div class="mt-10 grid gap-6 md:grid-cols-3">
                    @foreach ($templates as $key => $template)
                        <a href="{{ route('templates.demo', $key) }}" class="home-card group block rounded-3xl p-4 hover:-translate-y-1">
                            <x-template-thumb :template="$key" class="transition group-hover:scale-[1.02]" />
                            <div class="px-1 pb-1 pt-4">
                                <h3 class="font-semibold">{{ $template['name'] }}</h3>
                                <p class="mt-1 text-sm">{{ $template['description'] }}</p>
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
    </div>
</x-site-layout>