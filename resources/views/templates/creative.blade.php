{{-- Template 3 - Creative: colorful gradients, hero banner, timeline, animated project showcase --}}
@php
    $socials   = $portfolio->socialLinks?->filled() ?? [];
    $languages = \App\Support\ViewHelpers::split($portfolio->languages);
    $interests = \App\Support\ViewHelpers::split($portfolio->interests);
    $certs     = \App\Support\ViewHelpers::split($portfolio->certificates);

    // Gradient pairs cycled across skills and project cards (literal strings so Tailwind keeps them)
    $palette = [
        'from-fuchsia-500 to-pink-500',
        'from-orange-500 to-amber-400',
        'from-sky-500 to-indigo-500',
        'from-emerald-500 to-teal-400',
    ];
@endphp
<div class="tpl-creative bg-amber-50/60 text-slate-700">
    {{-- Animations for this template only --}}
    <style>
        .tpl-creative .pop-in { animation: tplCreativePop .7s cubic-bezier(.2,.9,.3,1.2) both; }
        .tpl-creative .drift { animation: tplCreativeDrift 9s ease-in-out infinite; }
        @keyframes tplCreativePop { from { opacity: 0; transform: translateY(30px) scale(.94) rotate(-1deg); } to { opacity: 1; transform: none; } }
        @keyframes tplCreativeDrift { 0%, 100% { transform: translateY(0) rotate(0); } 50% { transform: translateY(-18px) rotate(8deg); } }
        @media (prefers-reduced-motion: reduce) { .tpl-creative .pop-in, .tpl-creative .drift { animation: none; } }
    </style>

    {{-- Hero banner --}}
    <header class="relative overflow-hidden bg-gradient-to-br from-fuchsia-600 via-orange-500 to-amber-400 pb-24 pt-16 text-white">
        <div class="drift absolute -left-10 top-6 h-40 w-40 rounded-full bg-white/20"></div>
        <div class="drift absolute right-10 top-20 h-24 w-24 rotate-12 rounded-3xl bg-white/20" style="animation-delay: -3s"></div>
        <div class="drift absolute bottom-6 left-1/3 h-16 w-16 rounded-full bg-yellow-200/40" style="animation-delay: -5s"></div>
        <div class="relative mx-auto max-w-5xl px-4 text-center sm:px-6">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-white/80">Hello, I am</p>
            <h1 class="mt-3 text-5xl font-black tracking-tight drop-shadow sm:text-7xl">{{ $portfolio->full_name }}</h1>
            <p class="mx-auto mt-4 inline-block rounded-full bg-white/20 px-5 py-2 text-lg font-semibold backdrop-blur">{{ $portfolio->professional_title }}</p>
        </div>
    </header>

    <div class="relative mx-auto -mt-16 max-w-5xl space-y-14 px-4 pb-16 sm:px-6">

        {{-- Intro card overlapping the banner --}}
        <section class="pop-in rounded-[2rem] bg-white p-6 shadow-xl shadow-orange-200/50 sm:p-10">
            <div class="flex flex-col items-center gap-6 sm:flex-row">
                @if ($portfolio->profile_picture_url)
                    <img src="{{ $portfolio->profile_picture_url }}" alt="Photo of {{ $portfolio->full_name }}" class="-mt-20 h-36 w-36 rounded-3xl border-8 border-white object-cover shadow-lg sm:-mt-24 sm:h-40 sm:w-40">
                @else
                    <span class="-mt-20 flex h-36 w-36 items-center justify-center rounded-3xl border-8 border-white bg-gradient-to-br from-fuchsia-500 to-orange-400 text-5xl font-black text-white shadow-lg sm:-mt-24 sm:h-40 sm:w-40">{{ $portfolio->initials }}</span>
                @endif
                <div class="flex-1 text-center sm:text-left">
                    <p class="whitespace-pre-line text-lg leading-relaxed">{{ $portfolio->about }}</p>
                    <div class="mt-4 flex flex-wrap justify-center gap-x-5 gap-y-1 text-sm font-medium text-slate-500 sm:justify-start">
                        <a href="mailto:{{ $portfolio->email }}" class="hover:text-fuchsia-600">{{ $portfolio->email }}</a>
                        <span>{{ $portfolio->contact_number }}</span>
                        @if ($portfolio->address)<span>{{ $portfolio->address }}</span>@endif
                    </div>
                    <div class="mt-4 flex flex-wrap justify-center gap-2 sm:justify-start">
                        @foreach ($socials as $platform => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="rounded-full bg-slate-900 px-4 py-1.5 text-xs font-bold text-white transition hover:-translate-y-0.5 hover:bg-fuchsia-600">{{ \App\Support\ViewHelpers::socialLabel($platform) }}</a>
                        @endforeach
                        @if ($portfolio->resume_url)
                            <a href="{{ $portfolio->resume_url }}" target="_blank" rel="noopener" class="rounded-full bg-gradient-to-r from-fuchsia-500 to-orange-400 px-4 py-1.5 text-xs font-bold text-white transition hover:-translate-y-0.5">Resume</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- Skills as colorful chips --}}
        @if ($portfolio->skills->count())
            <section>
                <h2 class="text-center text-3xl font-black tracking-tight text-slate-900">My toolbox</h2>
                <div class="mt-6 flex flex-wrap justify-center gap-3">
                    @foreach ($portfolio->skills as $i => $skill)
                        <span class="pop-in rounded-2xl bg-gradient-to-r {{ $palette[$i % 4] }} px-5 py-2 font-bold text-white shadow-md transition hover:-translate-y-1 hover:rotate-2" style="animation-delay: {{ $i * 60 }}ms">{{ $skill->skill_name }}</span>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Animated project showcase --}}
        @if ($portfolio->projects->count())
            <section>
                <h2 class="text-center text-3xl font-black tracking-tight text-slate-900">Featured projects</h2>
                <div class="mt-8 grid gap-6 md:grid-cols-2">
                    @foreach ($portfolio->projects as $i => $project)
                        <article class="pop-in group overflow-hidden rounded-3xl bg-white shadow-lg transition duration-300 hover:-translate-y-2 hover:rotate-1 hover:shadow-2xl" style="animation-delay: {{ $i * 120 }}ms">
                            <div class="flex h-24 items-end bg-gradient-to-br {{ $palette[$i % 4] }} p-5">
                                <span class="text-5xl font-black text-white/40 transition group-hover:text-white/70">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-extrabold text-slate-900">{{ $project->project_name }}</h3>
                                @if ($project->description)<p class="mt-2 text-sm leading-relaxed">{{ $project->description }}</p>@endif
                                @if ($project->technologyList())
                                    <div class="mt-4 flex flex-wrap gap-1.5">
                                        @foreach ($project->technologyList() as $tech)
                                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ $tech }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="mt-5 flex gap-4 text-sm font-bold">
                                    @if ($project->github_link)<a href="{{ $project->github_link }}" target="_blank" rel="noopener noreferrer" class="text-fuchsia-600 hover:underline">Code &rarr;</a>@endif
                                    @if ($project->demo_link)<a href="{{ $project->demo_link }}" target="_blank" rel="noopener noreferrer" class="text-orange-600 hover:underline">Live demo &rarr;</a>@endif
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Timelines for experience and education --}}
        @if ($portfolio->experiences->count() || $portfolio->educations->count())
            <section class="grid gap-12 md:grid-cols-2">
                @if ($portfolio->experiences->count())
                    <div>
                        <h2 class="text-3xl font-black tracking-tight text-slate-900">Work journey</h2>
                        <ol class="relative mt-8 space-y-8 border-l-4 border-orange-200 pl-8">
                            @foreach ($portfolio->experiences as $job)
                                <li class="relative">
                                    <span class="absolute -left-[44px] top-1 h-5 w-5 rounded-full border-4 border-white bg-gradient-to-br from-orange-500 to-amber-400 shadow"></span>
                                    <p class="text-xs font-bold uppercase tracking-widest text-orange-600">{{ $job->period() }}</p>
                                    <h3 class="text-lg font-extrabold text-slate-900">{{ $job->position }}</h3>
                                    <p class="text-sm font-semibold text-slate-500">{{ $job->company }}</p>
                                    @if ($job->description)<p class="mt-1.5 whitespace-pre-line text-sm">{{ $job->description }}</p>@endif
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif

                @if ($portfolio->educations->count())
                    <div>
                        <h2 class="text-3xl font-black tracking-tight text-slate-900">Learning path</h2>
                        <ol class="relative mt-8 space-y-8 border-l-4 border-fuchsia-200 pl-8">
                            @foreach ($portfolio->educations as $edu)
                                <li class="relative">
                                    <span class="absolute -left-[44px] top-1 h-5 w-5 rounded-full border-4 border-white bg-gradient-to-br from-fuchsia-500 to-pink-500 shadow"></span>
                                    <p class="text-xs font-bold uppercase tracking-widest text-fuchsia-600">{{ $edu->year_started }} &ndash; {{ $edu->year_graduated ?? 'Present' }}</p>
                                    <h3 class="text-lg font-extrabold text-slate-900">{{ $edu->school }}</h3>
                                    <p class="text-sm font-semibold text-slate-500">{{ $edu->degree }}</p>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                @endif
            </section>
        @endif

        {{-- Extras --}}
        @if ($certs || $languages || $interests)
            <section class="grid gap-6 sm:grid-cols-3">
                @if ($certs)
                    <div class="rounded-3xl bg-white p-6 shadow-md"><h2 class="font-black text-slate-900">Certificates</h2><ul class="mt-2 space-y-1 text-sm">@foreach ($certs as $cert)<li>{{ $cert }}</li>@endforeach</ul></div>
                @endif
                @if ($languages)
                    <div class="rounded-3xl bg-white p-6 shadow-md"><h2 class="font-black text-slate-900">Languages</h2><p class="mt-2 text-sm">{{ implode(', ', $languages) }}</p></div>
                @endif
                @if ($interests)
                    <div class="rounded-3xl bg-white p-6 shadow-md"><h2 class="font-black text-slate-900">Interests</h2><p class="mt-2 text-sm">{{ implode(', ', $interests) }}</p></div>
                @endif
            </section>
        @endif
    </div>
</div>
