{{-- Template 1 - Simple (Dark Gradient): dark background, sidebar profile, serif headings, glowing gradient accents --}}
@php
    $socials   = $portfolio->socialLinks?->filled() ?? [];
    $languages = \App\Support\ViewHelpers::split($portfolio->languages);
    $interests = \App\Support\ViewHelpers::split($portfolio->interests);
    $certs     = \App\Support\ViewHelpers::split($portfolio->certificates);
    $phoneHref = preg_replace('/[^0-9+]/', '', (string) $portfolio->contact_number);
@endphp
<div class="relative bg-slate-950 text-slate-300">

    {{-- Decorative gradient glow (purely visual) --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950/60"></div>
        <div class="absolute -left-32 -top-32 h-96 w-96 rounded-full bg-violet-600/20 blur-3xl"></div>
        <div class="absolute right-0 top-1/3 h-96 w-96 rounded-full bg-fuchsia-600/10 blur-3xl"></div>
        <div class="absolute -bottom-32 left-1/4 h-96 w-96 rounded-full bg-cyan-500/10 blur-3xl"></div>
    </div>

    <div class="relative mx-auto grid max-w-5xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[280px_1fr] lg:gap-16 lg:py-16">

        {{-- Sidebar: photo, name, contact, links, skills --}}
        <aside class="space-y-8 lg:sticky lg:top-6 lg:self-start">
            <div class="text-center lg:text-left">
                @if ($portfolio->profile_picture_url)
                    <span class="mx-auto block h-40 w-40 rounded-full bg-gradient-to-br from-violet-500 via-fuchsia-500 to-cyan-400 p-[3px] shadow-lg shadow-violet-900/40 lg:mx-0">
                        <img src="{{ $portfolio->profile_picture_url }}" alt="Photo of {{ $portfolio->full_name }}" class="h-full w-full rounded-full border-2 border-slate-950 object-cover">
                    </span>
                @else
                    <span class="mx-auto flex h-40 w-40 items-center justify-center rounded-full bg-gradient-to-br from-violet-600 via-fuchsia-600 to-indigo-600 font-serif text-5xl text-white shadow-lg shadow-violet-900/40 lg:mx-0">{{ $portfolio->initials }}</span>
                @endif
                <h1 class="mt-6 bg-gradient-to-r from-white via-violet-200 to-cyan-200 bg-clip-text font-serif text-3xl font-semibold tracking-tight text-transparent">{{ $portfolio->full_name }}</h1>
                <p class="mt-1 text-xs font-medium uppercase tracking-[0.2em] text-violet-300/80">{{ $portfolio->professional_title }}</p>
            </div>

            <div class="rounded-xl border border-white/10 bg-white/5 p-4 backdrop-blur">
                <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Contact</h2>
                <dl class="mt-3 space-y-2 text-sm">
                    <div><dt class="sr-only">Email</dt><dd><a href="mailto:{{ $portfolio->email }}" class="break-all text-slate-300 hover:text-violet-300 hover:underline">{{ $portfolio->email }}</a></dd></div>
                    <div><dt class="sr-only">Phone</dt><dd><a href="tel:{{ $phoneHref }}" class="text-slate-300 hover:text-violet-300 hover:underline">{{ $portfolio->contact_number }}</a></dd></div>
                    @if ($portfolio->address)<div><dt class="sr-only">Address</dt><dd>{{ $portfolio->address }}</dd></div>@endif
                </dl>
            </div>

            @if ($socials)
                <div>
                    <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Elsewhere</h2>
                    <ul class="mt-3 space-y-1.5 text-sm">
                        @foreach ($socials as $platform => $url)
                            <li><a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="text-slate-300 hover:text-violet-300 hover:underline">{{ \App\Support\ViewHelpers::socialLabel($platform) }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($portfolio->skills->count())
                <div>
                    <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Skills</h2>
                    <ul class="mt-3 space-y-1.5 text-sm">
                        @foreach ($portfolio->skills as $skill)
                            <li class="flex items-center gap-2"><span class="h-px w-3 bg-gradient-to-r from-violet-400 to-cyan-400"></span>{{ $skill->skill_name }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($languages)
                <div>
                    <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Languages</h2>
                    <p class="mt-3 text-sm">{{ implode(', ', $languages) }}</p>
                </div>
            @endif

            @if ($interests)
                <div>
                    <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Interests</h2>
                    <p class="mt-3 text-sm">{{ implode(', ', $interests) }}</p>
                </div>
            @endif

            @if ($portfolio->resume_url)
                <a href="{{ $portfolio->resume_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-md bg-gradient-to-r from-violet-600 to-fuchsia-600 px-4 py-2 text-sm font-medium text-white shadow-lg shadow-violet-900/40 transition hover:from-violet-500 hover:to-fuchsia-500 hover:shadow-violet-700/50">
                    <x-icon name="document" class="h-4 w-4" /> Download resume
                </a>
            @endif
        </aside>

        {{-- Main column: about, experience, education, projects, certificates --}}
        <div class="space-y-12">
            <section>
                <h2 class="relative border-b border-white/10 pb-2 font-serif text-2xl text-white after:absolute after:-bottom-px after:left-0 after:h-px after:w-20 after:bg-gradient-to-r after:from-violet-400 after:to-cyan-400">About</h2>
                <p class="mt-4 whitespace-pre-line leading-relaxed">{{ $portfolio->about }}</p>
            </section>

            @if ($portfolio->experiences->count())
                <section>
                    <h2 class="relative border-b border-white/10 pb-2 font-serif text-2xl text-white after:absolute after:-bottom-px after:left-0 after:h-px after:w-20 after:bg-gradient-to-r after:from-violet-400 after:to-cyan-400">Experience</h2>
                    <div class="mt-5 space-y-4">
                        @foreach ($portfolio->experiences as $job)
                            <article class="rounded-xl border border-white/10 bg-gradient-to-br from-white/5 to-transparent p-4 transition hover:border-violet-400/30">
                                <div class="flex flex-wrap items-baseline justify-between gap-x-4">
                                    <h3 class="font-semibold text-white">{{ $job->position }} <span class="font-normal text-slate-400">at {{ $job->company }}</span></h3>
                                    <span class="text-sm text-violet-300/80">{{ $job->period() }}</span>
                                </div>
                                @if ($job->description)<p class="mt-1.5 whitespace-pre-line text-sm leading-relaxed">{{ $job->description }}</p>@endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($portfolio->educations->count())
                <section>
                    <h2 class="relative border-b border-white/10 pb-2 font-serif text-2xl text-white after:absolute after:-bottom-px after:left-0 after:h-px after:w-20 after:bg-gradient-to-r after:from-violet-400 after:to-cyan-400">Education</h2>
                    <div class="mt-5 space-y-4">
                        @foreach ($portfolio->educations as $edu)
                            <article class="flex flex-wrap items-baseline justify-between gap-x-4 rounded-xl border border-white/10 bg-gradient-to-br from-white/5 to-transparent p-4 transition hover:border-violet-400/30">
                                <div>
                                    <h3 class="font-semibold text-white">{{ $edu->school }}</h3>
                                    <p class="text-sm text-slate-400">{{ $edu->degree }}</p>
                                </div>
                                <span class="text-sm text-violet-300/80">{{ $edu->year_started }} &ndash; {{ $edu->year_graduated ?? 'Present' }}</span>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($portfolio->projects->count())
                <section>
                    <h2 class="relative border-b border-white/10 pb-2 font-serif text-2xl text-white after:absolute after:-bottom-px after:left-0 after:h-px after:w-20 after:bg-gradient-to-r after:from-violet-400 after:to-cyan-400">Projects</h2>
                    <div class="mt-5 space-y-4">
                        @foreach ($portfolio->projects as $project)
                            <article class="rounded-xl border border-white/10 bg-gradient-to-br from-white/5 to-transparent p-5 transition hover:border-violet-400/30">
                                <h3 class="font-semibold text-white">{{ $project->project_name }}</h3>
                                @if ($project->description)<p class="mt-1 text-sm leading-relaxed">{{ $project->description }}</p>@endif
                                @if ($project->technologyList())
                                    <p class="mt-2 bg-gradient-to-r from-violet-300 to-cyan-300 bg-clip-text text-xs uppercase tracking-wider text-transparent">{{ implode(' / ', $project->technologyList()) }}</p>
                                @endif
                                <p class="mt-2 flex gap-4 text-sm">
                                    @if ($project->github_link)<a href="{{ $project->github_link }}" target="_blank" rel="noopener noreferrer" class="font-medium text-white underline decoration-violet-400/50 underline-offset-4 hover:text-violet-300 hover:decoration-violet-300">Source code</a>@endif
                                    @if ($project->demo_link)<a href="{{ $project->demo_link }}" target="_blank" rel="noopener noreferrer" class="font-medium text-white underline decoration-violet-400/50 underline-offset-4 hover:text-violet-300 hover:decoration-violet-300">Live demo</a>@endif
                                </p>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($certs)
                <section>
                    <h2 class="relative border-b border-white/10 pb-2 font-serif text-2xl text-white after:absolute after:-bottom-px after:left-0 after:h-px after:w-20 after:bg-gradient-to-r after:from-violet-400 after:to-cyan-400">Certificates</h2>
                    <ul class="mt-4 list-disc space-y-1 pl-5 text-sm marker:text-violet-400">
                        @foreach ($certs as $cert)<li>{{ $cert }}</li>@endforeach
                    </ul>
                </section>
            @endif
        </div>
    </div>
</div>