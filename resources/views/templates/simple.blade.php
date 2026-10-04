{{-- Template 1 - Simple: white background, sidebar profile, serif headings, clean sections --}}
@php
    $socials   = $portfolio->socialLinks?->filled() ?? [];
    $languages = \App\Support\ViewHelpers::split($portfolio->languages);
    $interests = \App\Support\ViewHelpers::split($portfolio->interests);
    $certs     = \App\Support\ViewHelpers::split($portfolio->certificates);
    $phoneHref = preg_replace('/[^0-9+]/', '', (string) $portfolio->contact_number);
@endphp
<div class="bg-white text-slate-700">
    <div class="mx-auto grid max-w-5xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-[280px_1fr] lg:gap-16 lg:py-16">

        {{-- Sidebar: photo, name, contact, links, skills --}}
        <aside class="space-y-8 lg:sticky lg:top-6 lg:self-start">
            <div class="text-center lg:text-left">
                @if ($portfolio->profile_picture_url)
                    <img src="{{ $portfolio->profile_picture_url }}" alt="Photo of {{ $portfolio->full_name }}" class="mx-auto h-40 w-40 rounded-full object-cover ring-1 ring-slate-200 lg:mx-0">
                @else
                    <span class="mx-auto flex h-40 w-40 items-center justify-center rounded-full bg-slate-100 font-serif text-5xl text-slate-500 lg:mx-0">{{ $portfolio->initials }}</span>
                @endif
                <h1 class="mt-6 font-serif text-3xl font-semibold tracking-tight text-slate-900">{{ $portfolio->full_name }}</h1>
                <p class="mt-1 text-xs font-medium uppercase tracking-[0.2em] text-slate-500">{{ $portfolio->professional_title }}</p>
            </div>

            <div>
                <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Contact</h2>
                <dl class="mt-3 space-y-2 text-sm">
                    <div><dt class="sr-only">Email</dt><dd><a href="mailto:{{ $portfolio->email }}" class="break-all hover:text-slate-900 hover:underline">{{ $portfolio->email }}</a></dd></div>
                    <div><dt class="sr-only">Phone</dt><dd><a href="tel:{{ $phoneHref }}" class="hover:text-slate-900 hover:underline">{{ $portfolio->contact_number }}</a></dd></div>
                    @if ($portfolio->address)<div><dt class="sr-only">Address</dt><dd>{{ $portfolio->address }}</dd></div>@endif
                </dl>
            </div>

            @if ($socials)
                <div>
                    <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Elsewhere</h2>
                    <ul class="mt-3 space-y-1.5 text-sm">
                        @foreach ($socials as $platform => $url)
                            <li><a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="hover:text-slate-900 hover:underline">{{ \App\Support\ViewHelpers::socialLabel($platform) }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($portfolio->skills->count())
                <div>
                    <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Skills</h2>
                    <ul class="mt-3 space-y-1.5 text-sm">
                        @foreach ($portfolio->skills as $skill)
                            <li class="flex items-center gap-2"><span class="h-px w-3 bg-slate-400"></span>{{ $skill->skill_name }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($languages)
                <div>
                    <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Languages</h2>
                    <p class="mt-3 text-sm">{{ implode(', ', $languages) }}</p>
                </div>
            @endif

            @if ($interests)
                <div>
                    <h2 class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Interests</h2>
                    <p class="mt-3 text-sm">{{ implode(', ', $interests) }}</p>
                </div>
            @endif

            @if ($portfolio->resume_url)
                <a href="{{ $portfolio->resume_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-md border border-slate-900 px-4 py-2 text-sm font-medium text-slate-900 transition hover:bg-slate-900 hover:text-white">
                    <x-icon name="document" class="h-4 w-4" /> Download resume
                </a>
            @endif
        </aside>

        {{-- Main column: about, experience, education, projects, certificates --}}
        <div class="space-y-12">
            <section>
                <h2 class="border-b border-slate-200 pb-2 font-serif text-2xl text-slate-900">About</h2>
                <p class="mt-4 whitespace-pre-line leading-relaxed">{{ $portfolio->about }}</p>
            </section>

            @if ($portfolio->experiences->count())
                <section>
                    <h2 class="border-b border-slate-200 pb-2 font-serif text-2xl text-slate-900">Experience</h2>
                    <div class="mt-5 space-y-6">
                        @foreach ($portfolio->experiences as $job)
                            <article>
                                <div class="flex flex-wrap items-baseline justify-between gap-x-4">
                                    <h3 class="font-semibold text-slate-900">{{ $job->position }} <span class="font-normal text-slate-500">at {{ $job->company }}</span></h3>
                                    <span class="text-sm text-slate-500">{{ $job->period() }}</span>
                                </div>
                                @if ($job->description)<p class="mt-1.5 whitespace-pre-line text-sm leading-relaxed">{{ $job->description }}</p>@endif
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($portfolio->educations->count())
                <section>
                    <h2 class="border-b border-slate-200 pb-2 font-serif text-2xl text-slate-900">Education</h2>
                    <div class="mt-5 space-y-5">
                        @foreach ($portfolio->educations as $edu)
                            <article class="flex flex-wrap items-baseline justify-between gap-x-4">
                                <div>
                                    <h3 class="font-semibold text-slate-900">{{ $edu->school }}</h3>
                                    <p class="text-sm text-slate-600">{{ $edu->degree }}</p>
                                </div>
                                <span class="text-sm text-slate-500">{{ $edu->year_started }} &ndash; {{ $edu->year_graduated ?? 'Present' }}</span>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($portfolio->projects->count())
                <section>
                    <h2 class="border-b border-slate-200 pb-2 font-serif text-2xl text-slate-900">Projects</h2>
                    <div class="mt-5 space-y-7">
                        @foreach ($portfolio->projects as $project)
                            <article>
                                <h3 class="font-semibold text-slate-900">{{ $project->project_name }}</h3>
                                @if ($project->description)<p class="mt-1 text-sm leading-relaxed">{{ $project->description }}</p>@endif
                                @if ($project->technologyList())
                                    <p class="mt-2 text-xs uppercase tracking-wider text-slate-500">{{ implode(' / ', $project->technologyList()) }}</p>
                                @endif
                                <p class="mt-2 flex gap-4 text-sm">
                                    @if ($project->github_link)<a href="{{ $project->github_link }}" target="_blank" rel="noopener noreferrer" class="font-medium text-slate-900 underline decoration-slate-300 underline-offset-4 hover:decoration-slate-900">Source code</a>@endif
                                    @if ($project->demo_link)<a href="{{ $project->demo_link }}" target="_blank" rel="noopener noreferrer" class="font-medium text-slate-900 underline decoration-slate-300 underline-offset-4 hover:decoration-slate-900">Live demo</a>@endif
                                </p>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif

            @if ($certs)
                <section>
                    <h2 class="border-b border-slate-200 pb-2 font-serif text-2xl text-slate-900">Certificates</h2>
                    <ul class="mt-4 list-disc space-y-1 pl-5 text-sm">
                        @foreach ($certs as $cert)<li>{{ $cert }}</li>@endforeach
                    </ul>
                </section>
            @endif
        </div>
    </div>
</div>
