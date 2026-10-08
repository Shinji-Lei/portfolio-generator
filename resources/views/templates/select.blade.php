{{-- Template selection for a saved portfolio. Expects $portfolio and $templates --}}
<x-site-layout title="Choose a template">

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
            .sel-page { min-height: 100vh; min-height: 100dvh; }

            .sel-title { color: #ffffff; }
            .sel-lead  { color: #cbd5e1; }

            /* Progress steps */
            .sel-step-done   { color: #6ee7b7; }
            .sel-step-done span   { background: rgba(16, 185, 129, 0.2); }
            .sel-step-active { color: #c7d2fe; }
            .sel-step-active span { background: linear-gradient(90deg, #4f46e5, #7c3aed); color: #ffffff; }
            .sel-step-next   { color: #94a3b8; }
            .sel-step-next span   { background: rgba(255, 255, 255, 0.09); }
            .sel-line { background: rgba(255, 255, 255, 0.22); }

            /* Error message */
            .sel-alert {
                background: rgba(244, 63, 94, 0.12);
                border: 1px solid rgba(251, 113, 133, 0.45);
                color: #fecdd3;
            }

            /* Dark glass cards */
            .sel-card {
                background: rgba(255, 255, 255, 0.05);
                -webkit-backdrop-filter: blur(12px);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.12);
                box-shadow: 0 10px 30px rgba(2, 6, 23, 0.45);
                transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
            }
            .sel-card:hover {
                transform: translateY(-4px);
                border-color: rgba(129, 140, 248, 0.65);
                box-shadow: 0 16px 40px rgba(2, 6, 23, 0.55), 0 0 0 1px rgba(129, 140, 248, 0.25);
            }
            .sel-card-current {
                border-color: rgba(129, 140, 248, 0.85);
                box-shadow: 0 10px 30px rgba(2, 6, 23, 0.45), 0 0 0 2px rgba(129, 140, 248, 0.35);
            }
            .sel-card h2 { color: #ffffff; }
            .sel-card p  { color: #cbd5e1; }
            .sel-badge { background: rgba(99, 102, 241, 0.25); color: #c7d2fe; }

            /* Buttons */
            .sel-btn-ghost {
                color: #ffffff;
                background: transparent;
                border: 1px solid rgba(255, 255, 255, 0.35);
                transition: background-color 0.15s ease, border-color 0.15s ease;
            }
            .sel-btn-ghost:hover { background: rgba(255, 255, 255, 0.12); border-color: rgba(255, 255, 255, 0.6); }
            .sel-btn-solid {
                color: #ffffff;
                background: linear-gradient(90deg, #4f46e5, #7c3aed);
                box-shadow: 0 6px 18px rgba(99, 102, 241, 0.35);
                transition: filter 0.15s ease, box-shadow 0.15s ease;
            }
            .sel-btn-solid:hover { filter: brightness(1.12); box-shadow: 0 8px 24px rgba(124, 58, 237, 0.45); }
            .sel-btn-ghost:focus-visible,
            .sel-btn-solid:focus-visible,
            .sel-link:focus-visible { outline: 2px solid #a5b4fc; outline-offset: 2px; }

            /* Links under the cards */
            .sel-link { color: #a5b4fc; transition: color 0.15s ease; }
            .sel-link:hover { color: #ffffff; }
            .sel-link-muted { color: #94a3b8; }

            @media (prefers-reduced-motion: reduce) {
                .sel-card { transition: none; }
                .sel-card:hover { transform: none; }
            }
        </style>
    @endpush

    <section class="sel-page mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">

        {{-- Progress steps --}}
        <ol class="mx-auto mb-10 flex max-w-xl items-center justify-center gap-2 text-sm font-medium" aria-label="Progress">
            <li class="sel-step-done flex items-center gap-2"><span class="flex h-7 w-7 items-center justify-center rounded-full">1</span> Information</li>
            <li class="sel-line h-px w-8"></li>
            <li class="sel-step-active flex items-center gap-2"><span class="flex h-7 w-7 items-center justify-center rounded-full">2</span> Template</li>
            <li class="sel-line h-px w-8"></li>
            <li class="sel-step-next flex items-center gap-2"><span class="flex h-7 w-7 items-center justify-center rounded-full">3</span> Preview</li>
        </ol>

        <div class="text-center">
            <h1 class="sel-title text-3xl font-bold tracking-tight">Choose a template for {{ $portfolio->full_name }}</h1>
            <p class="sel-lead mt-2">Preview any template with your own data, then select the one you like. You can change it later.</p>
        </div>

        @error('selected_template')
            <div class="sel-alert mx-auto mt-6 max-w-xl rounded-2xl p-4 text-sm" role="alert">{{ $message }}</div>
        @enderror

        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach ($templates as $key => $template)
                @php $isCurrent = $portfolio->selected_template === $key; @endphp
                <article class="sel-card flex flex-col rounded-3xl p-4 {{ $isCurrent ? 'sel-card-current' : '' }}">
                    <x-template-thumb :template="$key" />
                    <div class="flex-1 px-1 pb-2 pt-5">
                        <div class="flex items-center justify-between gap-2">
                            <h2 class="text-lg font-semibold">{{ $template['name'] }}</h2>
                            @if ($isCurrent)<span class="sel-badge rounded-full px-2.5 py-1 text-xs font-semibold">Selected</span>@endif
                        </div>
                        <p class="mt-1 text-sm leading-relaxed">{{ $template['description'] }}</p>
                    </div>
                    <div class="mt-3 flex gap-2">
                        <a href="{{ route('portfolios.preview', [$portfolio, $key]) }}" class="sel-btn-ghost inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl px-4 py-2.5 text-sm font-semibold">
                            <x-icon name="eye" class="h-4 w-4" /> Preview
                        </a>
                        <form method="POST" action="{{ route('portfolios.template.update', $portfolio) }}" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="selected_template" value="{{ $key }}">
                            <button type="submit" class="sel-btn-solid w-full rounded-xl px-4 py-2.5 text-sm font-semibold">Select</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8 flex justify-center gap-4 text-sm">
            <a href="{{ route('portfolios.edit', $portfolio) }}" class="sel-link font-medium">&larr; Edit information</a>
            <a href="{{ route('portfolios.index') }}" class="sel-link-muted font-medium hover:text-white">My portfolios</a>
        </div>
    </section>
</x-site-layout>