<x-site-layout title="Templates">

    {{-- Gallery-only styles (plain CSS, so no Tailwind rebuild is needed) --}}
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
            .gallery-page {
                min-height: 100vh;
                min-height: 100dvh;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .gallery-title { color: #ffffff; }
            .gallery-lead  { color: #cbd5e1; }
            .gallery-note  { color: #94a3b8; }

            /* Dark glass cards */
            .gallery-card {
                background: rgba(255, 255, 255, 0.05);
                -webkit-backdrop-filter: blur(12px);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.12);
                box-shadow: 0 10px 30px rgba(2, 6, 23, 0.45);
                transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
            }
            .gallery-card:hover {
                transform: translateY(-4px);
                border-color: rgba(129, 140, 248, 0.65);
                box-shadow: 0 16px 40px rgba(2, 6, 23, 0.55), 0 0 0 1px rgba(129, 140, 248, 0.25);
            }
            .gallery-card h2 { color: #ffffff; }
            .gallery-card p  { color: #cbd5e1; }

            /* Buttons */
            .gallery-btn-ghost {
                color: #ffffff;
                border: 1px solid rgba(255, 255, 255, 0.35);
                background: transparent;
                transition: background-color 0.15s ease, border-color 0.15s ease;
            }
            .gallery-btn-ghost:hover { background: rgba(255, 255, 255, 0.12); border-color: rgba(255, 255, 255, 0.6); }
            .gallery-btn-solid {
                color: #ffffff;
                background: linear-gradient(90deg, #4f46e5, #7c3aed);
                box-shadow: 0 6px 18px rgba(99, 102, 241, 0.35);
                transition: filter 0.15s ease, box-shadow 0.15s ease;
            }
            .gallery-btn-solid:hover { filter: brightness(1.12); box-shadow: 0 8px 24px rgba(124, 58, 237, 0.45); }
            .gallery-btn-ghost:focus-visible,
            .gallery-btn-solid:focus-visible { outline: 2px solid #a5b4fc; outline-offset: 2px; }

            @media (prefers-reduced-motion: reduce) {
                .gallery-card { transition: none; }
                .gallery-card:hover { transform: none; }
            }
        </style>
    @endpush

    <section class="gallery-page mx-auto max-w-6xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="gallery-title text-4xl font-extrabold tracking-tight">Choose your style</h1>
            <p class="gallery-lead mt-3">Three templates, each with a distinct look. Preview them with sample data, then use your own details.</p>
        </div>

        <div class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach ($templates as $key => $template)
                <article class="gallery-card flex flex-col rounded-3xl p-4">
                    <x-template-thumb :template="$key" />
                    <div class="flex-1 px-1 pb-2 pt-5">
                        <h2 class="text-lg font-semibold">{{ $template['name'] }}</h2>
                        <p class="mt-1 text-sm leading-relaxed">{{ $template['description'] }}</p>
                    </div>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('templates.demo', $key) }}" class="gallery-btn-ghost inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl px-4 py-2.5 text-sm font-semibold">
                            <x-icon name="eye" class="h-4 w-4" /> Preview
                        </a>
                        <a href="{{ route('portfolios.create') }}" class="gallery-btn-solid inline-flex flex-1 items-center justify-center rounded-xl px-4 py-2.5 text-sm font-semibold">Select</a>
                    </div>
                </article>
            @endforeach
        </div>

        <p class="gallery-note mt-8 text-center text-sm">You pick the final template after entering your information.</p>
    </section>
</x-site-layout>