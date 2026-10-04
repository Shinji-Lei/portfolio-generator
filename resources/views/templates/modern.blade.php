{{-- Template 2 - Modern: dark mode, glassmorphism cards, gradient buttons, smooth animations --}}
@php
    $socials   = $portfolio->socialLinks?->filled() ?? [];
    $languages = \App\Support\ViewHelpers::split($portfolio->languages);
    $interests = \App\Support\ViewHelpers::split($portfolio->interests);
    $certs     = \App\Support\ViewHelpers::split($portfolio->certificates);
@endphp
<div class="tpl-modern relative overflow-hidden bg-slate-950 text-slate-300">
    {{-- Animations for this template only --}}
    <style>
        .tpl-modern .fade-up { animation: tplModernFadeUp .8s cubic-bezier(.2,.7,.2,1) both; }
        .tpl-modern .blob { animation: tplModernFloat 12s ease-in-out infinite; }
        @keyframes tplModernFadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: none; } }
        @keyframes tplModernFloat { 0%, 100% { transform: translate(0, 0) scale(1); } 50% { transform: translate(30px, -30px) scale(1.1); } }
        @media (prefers-reduced-motion: reduce) { .tpl-modern .fade-up, .tpl-modern .blob { animation: none; } }
    </style>

    {{-- Soft glowing background shapes --}}
    <div class="blob pointer-events-none absolute -left-24 top-10 h-96 w-96 rounded-full bg-indigo-600/30 blur-3xl"></div>
    <div class="blob pointer-events-none absolute -right-24 top-96 h-96 w-96 rounded-full bg-fuchsia-600/20 blur-3xl" style="animation-delay: -6s"></div>

    <div class="relative mx-auto max-w-5xl space-y-6 px-4 py-12 sm:px-6 lg:py-16">

        {{-- Hero card --}}
        <header class="fade-up rounded-3xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur-xl sm:p-10">
            <div class="flex flex-col items-center gap-6 text-center sm:flex-row sm:text-left">
                <div class="rounded-full bg-gradient-to-br from-indigo-400 via-fuchsia-500 to-pink-500 p-1">
                    @if ($portfolio->profile_picture_url)
                        <img src="{{ $portfolio->profile_picture_url }}" alt="Photo of {{ $portfolio->full_name }}" class="h-32 w-32 rounded-full border-4 border-slate-950 object-cover">
                    @else
                        <span class="flex h-32 w-32 items-center justify-center rounded-full border-4 border-slate-950 bg-slate-900 text-4xl font-bold text-white">{{ $portfolio->initials }}</span>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium uppercase tracking-widest text-indigo-300">{{ $portfolio->professional_title }}</p>
                    <h1 class="mt-1 bg-gradient-to-r from-white via-indigo-200 to-fuchsia-300 bg-clip-text text-4xl font-extrabold tracking-tight text-transparent sm:text-5xl">{{ $portfolio->full_name }}</h1>
                    <div class="mt-5 flex flex-wrap justify-center gap-3 sm:justify-start">
                        <a href="mailto:{{ $portfolio->email }}" class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-indigo-500 to-fuchsia-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:-translate-y-0.5 hover:shadow-indigo-500/50">Get in touch</a>
                        @if ($portfolio->resume_url)
                            <a href="{{ $portfolio->resume_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-white/20 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10">
                                <x-icon name="document" class="h-4 w-4" /> Resume
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        {{-- About and contact --}}
        <div class="grid gap-6 md:grid-cols-3">
            <section class="fade-up rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl md:col-span-2" style="animation-delay: .1s">
                <h2 class="text-lg font-semibold text-white">About me</h2>
                <p class="mt-3 whitespace-pre-line leading-relaxed">{{ $portfolio->about }}</p>
            </section>
            <section class="fade-up rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl" style="animation-delay: .2s">
                <h2 class="text-lg font-semibold text-white">Contact</h2>
                <ul class="mt-3 space-y-2 text-sm">
                    <li class="break-all">{{ $portfolio->email }}</li>
                    <li>{{ $portfolio->contact_number }}</li>
                    @if ($portfolio->address)<li>{{ $portfolio->address }}</li>@endif
                </ul>
                @if ($socials)
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($socials as $platform => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-medium text-indigo-200 transition hover:bg-white/15">{{ \App\Support\ViewHelpers::socialLabel($platform) }}</a>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        {{-- Skills --}}
        @if ($portfolio->skills->count())
            <section class="fade-up rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl" style="animation-delay: .3s">
                <h2 class="text-lg font-semibold text-white">Skills</h2>
                <div class="mt-4 flex flex-wrap gap-2.5">
                    @foreach ($portfolio->skills as $skill)
                        <span class="rounded-full border border-indigo-400/30 bg-indigo-500/10 px-4 py-1.5 text-sm font-medium text-indigo-200 transition hover:-translate-y-0.5 hover:bg-indigo-500/20">{{ $skill->skill_name }}</span>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Projects --}}
        @if ($portfolio->projects->count())
            <section class="fade-up" style="animation-delay: .4s">
                <h2 class="mb-4 px-1 text-lg font-semibold text-white">Projects</h2>
                <div class="grid gap-5 md:grid-cols-2">
                    @foreach ($portfolio->projects as $project)
                        <article class="group rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl transition duration-300 hover:-translate-y-1.5 hover:border-indigo-400/40 hover:bg-white/10">
                            <h3 class="text-lg font-semibold text-white">{{ $project->project_name }}</h3>
                            @if ($project->description)<p class="mt-2 text-sm leading-relaxed">{{ $project->description }}</p>@endif
                            @if ($project->technologyList())
                                <div class="mt-4 flex flex-wrap gap-1.5">
                                    @foreach ($project->technologyList() as $tech)
                                        <span class="rounded-md bg-white/10 px-2 py-0.5 text-xs text-slate-200">{{ $tech }}</span>
                                    @endforeach
                                </div>
                            @endif
                            <div class="mt-5 flex gap-3 text-sm font-semibold">
                                @if ($project->github_link)<a href="{{ $project->github_link }}" target="_blank" rel="noopener noreferrer" class="text-indigo-300 transition hover:text-white">GitHub &rarr;</a>@endif
                                @if ($project->demo_link)<a href="{{ $project->demo_link }}" target="_blank" rel="noopener noreferrer" class="text-fuchsia-300 transition hover:text-white">Live demo &rarr;</a>@endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Experience and education side by side --}}
        <div class="grid gap-6 md:grid-cols-2">
            @if ($portfolio->experiences->count())
                <section class="fade-up rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl" style="animation-delay: .5s">
                    <h2 class="text-lg font-semibold text-white">Experience</h2>
                    <div class="mt-4 space-y-5">
                        @foreach ($portfolio->experiences as $job)
                            <article class="border-l-2 border-indigo-400/50 pl-4">
                                <h3 class="font-semibold text-white">{{ $job->position }}</h3>
                                <p class="text-sm text-indigo-300">{{ $job->company }} &middot; {{ $job->period() }}</p>
                                @if ($job->description)<p class="mt-1.5 whitespace-pre-line text-sm">{{ $job->description }}</p>@endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($portfolio->educations->count())
                <section class="fade-up rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl" style="animation-delay: .6s">
                    <h2 class="text-lg font-semibold text-white">Education</h2>
                    <div class="mt-4 space-y-5">
                        @foreach ($portfolio->educations as $edu)
                            <article class="border-l-2 border-fuchsia-400/50 pl-4">
                                <h3 class="font-semibold text-white">{{ $edu->school }}</h3>
                                <p class="text-sm">{{ $edu->degree }}</p>
                                <p class="text-sm text-fuchsia-300">{{ $edu->year_started }} &ndash; {{ $edu->year_graduated ?? 'Present' }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>

        {{-- Extras --}}
        @if ($certs || $languages || $interests)
            <section class="fade-up grid gap-6 rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur-xl sm:grid-cols-3" style="animation-delay: .7s">
                @if ($certs)
                    <div><h2 class="font-semibold text-white">Certificates</h2><ul class="mt-2 space-y-1 text-sm">@foreach ($certs as $cert)<li>{{ $cert }}</li>@endforeach</ul></div>
                @endif
                @if ($languages)
                    <div><h2 class="font-semibold text-white">Languages</h2><p class="mt-2 text-sm">{{ implode(', ', $languages) }}</p></div>
                @endif
                @if ($interests)
                    <div><h2 class="font-semibold text-white">Interests</h2><p class="mt-2 text-sm">{{ implode(', ', $interests) }}</p></div>
                @endif
            </section>
        @endif
    </div>
</div>
