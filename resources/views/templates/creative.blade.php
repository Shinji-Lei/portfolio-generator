{{-- Template 3 - Creative: Stark / J.A.R.V.I.S. interface (clean card layout, visual redesign only) --}}
@php
    $socials   = $portfolio->socialLinks?->filled() ?? [];
    $languages = \App\Support\ViewHelpers::split($portfolio->languages);
    $interests = \App\Support\ViewHelpers::split($portfolio->interests);
    $certs     = \App\Support\ViewHelpers::split($portfolio->certificates);
@endphp
<div class="tpl-creative relative overflow-hidden bg-[#05070a] text-slate-200" style="background-color:#050505; color:#e2e8f0;">
    {{-- All layout/spacing lives in this scoped block so it never depends on Tailwind being rebuilt. --}}
    <style>
        .tpl-creative {
            --cyan: #00d9ff;   --cyan-rgb: 0, 217, 255;
            --red: #e21b23;    --red-rgb: 226, 27, 35;
            --gold: #f5b642;   --gold-rgb: 245, 182, 66;
            --line: rgba(0, 217, 255, .16);
            --line-soft: rgba(255, 255, 255, .08);
            --muted: #94a3b8;
            --mono: ui-monospace, "SFMono-Regular", Menlo, Consolas, "Liberation Mono", monospace;
            isolation: isolate;
        }
        .tpl-creative *, .tpl-creative *::before, .tpl-creative *::after { box-sizing: border-box; }

        /* ---------- Background (static, quiet) ---------- */
        .tpl-creative .stk-bg { position: absolute; inset: 0; overflow: hidden; pointer-events: none; z-index: 0; }
        .tpl-creative .stk-bg-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
            background-size: 48px 48px;
            -webkit-mask: radial-gradient(ellipse at 50% 0%, #000 0%, transparent 75%);
                    mask: radial-gradient(ellipse at 50% 0%, #000 0%, transparent 75%);
        }
        .tpl-creative .stk-bg-red  { position: absolute; left: -14rem; top: -12rem; width: 32rem; height: 32rem; background: radial-gradient(circle, rgba(var(--red-rgb), .14), transparent 65%); }
        .tpl-creative .stk-bg-cyan { position: absolute; right: -14rem; top: 8rem; width: 34rem; height: 34rem; background: radial-gradient(circle, rgba(var(--cyan-rgb), .11), transparent 65%); }

        /* ---------- Layout ---------- */
        .tpl-creative .stk-wrap { position: relative; z-index: 1; max-width: 64rem; margin: 0 auto; padding: 2.5rem 1rem 4rem; display: grid; gap: 1.5rem; }
        @media (min-width: 640px) { .tpl-creative .stk-wrap { padding: 3.5rem 1.5rem 5rem; } }
        .tpl-creative .stk-grid-2   { display: grid; gap: 1.5rem; grid-template-columns: minmax(0, 1fr); }
        .tpl-creative .stk-grid-2-1 { display: grid; gap: 1.5rem; grid-template-columns: minmax(0, 1fr); }
        .tpl-creative .stk-grid-3   { display: grid; gap: 1.5rem; grid-template-columns: minmax(0, 1fr); }
        @media (min-width: 768px) {
            .tpl-creative .stk-grid-2   { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .tpl-creative .stk-grid-2-1 { grid-template-columns: minmax(0, 2fr) minmax(0, 1fr); }
            .tpl-creative .stk-grid-3   { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 2rem; }
        }
        .tpl-creative .stk-section-title { margin: .75rem 0 -.25rem; padding-left: .8rem; border-left: 2px solid var(--cyan); font-size: .95rem; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; color: #fff; }

        /* ---------- Card ---------- */
        .tpl-creative .stk-card {
            position: relative; min-width: 0; padding: 1.5rem;
            border: 1px solid var(--line); border-radius: 8px;
            background: linear-gradient(160deg, rgba(26,30,37,.92), rgba(10,12,15,.96));
            box-shadow: inset 0 1px 0 rgba(255,255,255,.05), 0 18px 40px -24px rgba(0,0,0,.9);
            transition: border-color .25s ease;
            overflow-wrap: anywhere;
        }
        .tpl-creative .stk-card::before { content: ""; position: absolute; top: -1px; left: 1.5rem; width: 2.5rem; height: 2px; background: var(--cyan); box-shadow: 0 0 10px var(--cyan); }
        .tpl-creative .stk-card--red::before  { background: var(--red);  box-shadow: 0 0 10px var(--red); }
        .tpl-creative .stk-card--gold::before { background: var(--gold); box-shadow: 0 0 10px var(--gold); }
        .tpl-creative .stk-card:hover { border-color: rgba(var(--cyan-rgb), .38); }
        .tpl-creative .stk-card-title { margin: 0 0 1rem; font: 700 11px/1.3 var(--mono); letter-spacing: .22em; text-transform: uppercase; color: var(--cyan); }
        .tpl-creative .stk-card--red .stk-card-title  { color: #ff5a62; }
        .tpl-creative .stk-card--gold .stk-card-title { color: var(--gold); }
        .tpl-creative .stk-text { margin: 0; font-size: .95rem; line-height: 1.7; color: #cbd5e1; white-space: pre-line; }
        .tpl-creative .stk-muted { color: var(--muted); font-size: .875rem; }

        /* One quiet entrance: cards slide up slightly, never hidden */
        .tpl-creative .stk-wrap > * { animation: stkReveal .7s cubic-bezier(.2,.7,.2,1) backwards; }
        .tpl-creative .stk-wrap > *:nth-child(2) { animation-delay: 70ms; }
        .tpl-creative .stk-wrap > *:nth-child(3) { animation-delay: 140ms; }
        .tpl-creative .stk-wrap > *:nth-child(4) { animation-delay: 210ms; }
        .tpl-creative .stk-wrap > *:nth-child(5) { animation-delay: 280ms; }
        .tpl-creative .stk-wrap > *:nth-child(n+6) { animation-delay: 350ms; }

        /* ---------- Hero / profile ---------- */
        .tpl-creative .stk-hero { display: flex; flex-direction: column; align-items: center; gap: 1.5rem; text-align: center; padding: 1.75rem 1.5rem; }
        @media (min-width: 640px) { .tpl-creative .stk-hero { flex-direction: row; gap: 2rem; text-align: left; padding: 2rem; } }
        .tpl-creative .stk-hero-body { min-width: 0; flex: 1; }
        .tpl-creative .stk-eyebrow { display: inline-flex; align-items: center; gap: .55rem; font: 700 10px/1.3 var(--mono); letter-spacing: .24em; text-transform: uppercase; color: var(--cyan); }
        .tpl-creative .stk-eyebrow i { flex: none; width: 6px; height: 6px; border-radius: 50%; background: var(--cyan); box-shadow: 0 0 8px var(--cyan); animation: stkBlink 2s ease-in-out infinite; }
        .tpl-creative .stk-name { margin: .6rem 0 0; font-size: clamp(1.9rem, 6vw, 2.9rem); line-height: 1.05; font-weight: 900; letter-spacing: .01em; text-transform: uppercase; color: #fff; overflow-wrap: anywhere; text-shadow: 0 0 28px rgba(var(--cyan-rgb), .22); }
        .tpl-creative .stk-role { margin: .7rem 0 0; font-size: .8rem; font-weight: 700; letter-spacing: .22em; text-transform: uppercase; color: var(--muted); }
        .tpl-creative .stk-role::before { content: ""; display: inline-block; width: 6px; height: 6px; margin-right: .6rem; background: var(--gold); transform: rotate(45deg); vertical-align: 1px; }
        .tpl-creative .stk-hero-actions { margin-top: 1.4rem; display: flex; flex-wrap: wrap; justify-content: center; gap: .75rem; }
        @media (min-width: 640px) { .tpl-creative .stk-hero-actions { justify-content: flex-start; } }

        /* Arc-reactor-inspired avatar ring (original geometry) */
        .tpl-creative .stk-avatar { --size: 8rem; position: relative; flex: none; width: var(--size); height: var(--size); }
        @media (min-width: 640px) { .tpl-creative .stk-avatar { --size: 9.5rem; } }
        .tpl-creative .stk-ring { position: absolute; inset: 0; border-radius: 50%; pointer-events: none; }
        .tpl-creative .stk-ring-ticks {
            background: repeating-conic-gradient(rgba(var(--cyan-rgb), .75) 0 1.2deg, transparent 1.2deg 7.5deg);
            -webkit-mask: radial-gradient(closest-side, transparent 91%, #000 92%);
                    mask: radial-gradient(closest-side, transparent 91%, #000 92%);
            animation: stkSpin 60s linear infinite;
        }
        .tpl-creative .stk-ring-arc {
            inset: 6%;
            background: conic-gradient(var(--cyan) 0 80deg, transparent 80deg 175deg, var(--red) 175deg 215deg, transparent 215deg 360deg);
            -webkit-mask: radial-gradient(closest-side, transparent 93%, #000 94%);
                    mask: radial-gradient(closest-side, transparent 93%, #000 94%);
            animation: stkSpinRev 20s linear infinite;
        }
        .tpl-creative .stk-ring-dash { inset: 12%; border: 1px dashed rgba(var(--cyan-rgb), .3); animation: stkSpin 90s linear infinite; }
        .tpl-creative .stk-photo { position: absolute; inset: 17%; border-radius: 50%; overflow: hidden; border: 2px solid rgba(var(--cyan-rgb), .6); background: #0c0f14; box-shadow: 0 0 22px rgba(var(--cyan-rgb), .25); }
        .tpl-creative .stk-photo img { display: block; width: 100%; height: 100%; object-fit: cover; }
        .tpl-creative .stk-initials { display: flex; width: 100%; height: 100%; align-items: center; justify-content: center; font-size: 1.75rem; font-weight: 900; color: #fff; }

        /* ---------- Contact ---------- */
        .tpl-creative .stk-field + .stk-field { margin-top: .9rem; }
        .tpl-creative .stk-field-label { display: block; margin-bottom: .15rem; font: 700 10px/1.4 var(--mono); letter-spacing: .22em; text-transform: uppercase; color: var(--muted); }
        .tpl-creative .stk-field-value { font-size: .9rem; color: #e2e8f0; }
        .tpl-creative .stk-link { color: #e2e8f0; text-decoration: none; transition: color .2s; }
        .tpl-creative .stk-link:hover { color: var(--cyan); }
        .tpl-creative .stk-link:focus-visible { outline: 2px solid var(--cyan); outline-offset: 3px; border-radius: 2px; }
        .tpl-creative .stk-socials { margin-top: 1.1rem; display: flex; flex-wrap: wrap; gap: .5rem; }

        /* ---------- Buttons ---------- */
        .tpl-creative .stk-btn {
            display: inline-flex; align-items: center; justify-content: center; min-height: 2.5rem; padding: .55rem 1.1rem;
            border: 1px solid var(--b); border-radius: 4px; background: var(--bg); color: var(--c); text-decoration: none;
            font: 700 11px/1 var(--mono); letter-spacing: .16em; text-transform: uppercase;
            transition: box-shadow .25s ease, border-color .25s ease, background .25s ease, transform .2s ease;
        }
        .tpl-creative .stk-btn:hover { transform: translateY(-1px); box-shadow: 0 0 18px -3px var(--g); }
        .tpl-creative .stk-btn:active { transform: none; }
        .tpl-creative .stk-btn:focus-visible { outline: 2px solid #fff; outline-offset: 3px; }
        .tpl-creative .stk-btn--sm { min-height: 2rem; padding: .4rem .8rem; font-size: 10px; }
        .tpl-creative .stk-btn--cyan { --b: rgba(var(--cyan-rgb), .45); --c: var(--cyan); --bg: rgba(var(--cyan-rgb), .06); --g: rgba(var(--cyan-rgb), .6); }
        .tpl-creative .stk-btn--cyan:hover { border-color: var(--cyan); --bg: rgba(var(--cyan-rgb), .13); }
        .tpl-creative .stk-btn--red  { --b: rgba(var(--red-rgb), .7); --c: #fff; --bg: rgba(var(--red-rgb), .28); --g: rgba(var(--red-rgb), .7); }
        .tpl-creative .stk-btn--red:hover { border-color: var(--red); --bg: rgba(var(--red-rgb), .4); }

        /* ---------- Skills ---------- */
        .tpl-creative .stk-chips { display: flex; flex-wrap: wrap; gap: .6rem; }
        .tpl-creative .stk-chip { display: inline-flex; align-items: center; gap: .55rem; padding: .45rem .85rem; border: 1px solid var(--line-soft); border-radius: 4px; background: rgba(0,0,0,.4); font-size: .85rem; font-weight: 600; color: #e2e8f0; transition: border-color .25s ease, color .25s ease, box-shadow .25s ease; }
        .tpl-creative .stk-chip i { width: 5px; height: 5px; border-radius: 50%; background: var(--cyan); box-shadow: 0 0 6px var(--cyan); }
        .tpl-creative .stk-chip:hover { border-color: rgba(var(--cyan-rgb), .6); color: var(--cyan); box-shadow: 0 0 16px -4px rgba(var(--cyan-rgb), .5); }

        /* ---------- Projects ---------- */
        .tpl-creative .stk-project { display: flex; flex-direction: column; }
        .tpl-creative .stk-project-tag { margin: 0 0 .6rem; font: 700 10px/1 var(--mono); letter-spacing: .22em; text-transform: uppercase; color: #ff5a62; }
        .tpl-creative .stk-h3 { margin: 0; font-size: 1.1rem; font-weight: 800; color: #fff; }
        .tpl-creative .stk-project p.stk-muted { margin: .5rem 0 0; line-height: 1.6; }
        .tpl-creative .stk-tech-row { margin-top: 1rem; display: flex; flex-wrap: wrap; gap: .4rem; }
        .tpl-creative .stk-tech { padding: .28rem .55rem; border: 1px solid var(--line-soft); border-radius: 3px; background: rgba(0,0,0,.35); font: 600 10.5px/1 var(--mono); letter-spacing: .06em; text-transform: uppercase; color: var(--muted); }
        .tpl-creative .stk-actions { margin-top: auto; padding-top: 1.25rem; display: flex; flex-wrap: wrap; gap: .6rem; }

        /* ---------- Timeline ---------- */
        .tpl-creative .stk-timeline { --node: var(--red); position: relative; margin: 0; padding: 0 0 0 1.5rem; list-style: none; }
        .tpl-creative .stk-timeline--cyan { --node: var(--cyan); }
        .tpl-creative .stk-timeline::before { content: ""; position: absolute; left: 4px; top: .35rem; bottom: .35rem; width: 1px; background: linear-gradient(180deg, rgba(var(--cyan-rgb), .6), rgba(var(--cyan-rgb), .08)); }
        .tpl-creative .stk-timeline li { position: relative; }
        .tpl-creative .stk-timeline li + li { margin-top: 1.5rem; }
        .tpl-creative .stk-timeline li::before { content: ""; position: absolute; left: calc(-1.5rem + 4px - 5px); top: .3rem; width: 10px; height: 10px; border-radius: 50%; background: var(--node); box-shadow: 0 0 0 3px #0b0d10, 0 0 12px var(--node); }
        .tpl-creative .stk-time { margin: 0; font: 700 10.5px/1.4 var(--mono); letter-spacing: .14em; text-transform: uppercase; color: #64748b; }
        .tpl-creative .stk-h4 { margin: .25rem 0 0; font-size: 1rem; font-weight: 800; color: #fff; }
        .tpl-creative .stk-sub { margin: .1rem 0 0; font-size: .875rem; font-weight: 600; color: var(--muted); }
        .tpl-creative .stk-desc { margin: .5rem 0 0; font-size: .875rem; line-height: 1.6; color: var(--muted); white-space: pre-line; }

        /* ---------- Extras ---------- */
        .tpl-creative .stk-list { margin: 0; padding: 0; list-style: none; display: grid; gap: .4rem; font-size: .875rem; color: #cbd5e1; }
        .tpl-creative .stk-list li { display: flex; gap: .5rem; }
        .tpl-creative .stk-list li::before { content: "\203A"; color: var(--gold); font-weight: 800; }

        @keyframes stkSpin    { to { transform: rotate(360deg); } }
        @keyframes stkSpinRev { to { transform: rotate(-360deg); } }
        @keyframes stkBlink   { 0%, 100% { opacity: 1; } 50% { opacity: .35; } }
        @keyframes stkReveal  { from { transform: translateY(14px); } to { transform: none; } }

        @media (prefers-reduced-motion: reduce) {
            .tpl-creative *, .tpl-creative *::before, .tpl-creative *::after { animation: none !important; transition: none !important; }
        }
    </style>

    {{-- Quiet technical backdrop (decorative) --}}
    <div class="stk-bg" aria-hidden="true">
        <div class="stk-bg-grid"></div>
        <div class="stk-bg-red"></div>
        <div class="stk-bg-cyan"></div>
    </div>

    <div class="stk-wrap">

        {{-- Profile / identity --}}
        <header class="stk-card stk-card--gold stk-hero">
            <div class="stk-avatar">
                <span class="stk-ring stk-ring-ticks" aria-hidden="true"></span>
                <span class="stk-ring stk-ring-arc" aria-hidden="true"></span>
                <span class="stk-ring stk-ring-dash" aria-hidden="true"></span>
                <div class="stk-photo">
                    @if ($portfolio->profile_picture_url)
                        <img src="{{ $portfolio->profile_picture_url }}" alt="Photo of {{ $portfolio->full_name }}">
                    @else
                        <span class="stk-initials">{{ $portfolio->initials }}</span>
                    @endif
                </div>
            </div>

            <div class="stk-hero-body">
                <span class="stk-eyebrow"><i aria-hidden="true"></i>Stark Industries // Personal System</span>
                <h1 class="stk-name">{{ $portfolio->full_name }}</h1>
                <p class="stk-role">{{ $portfolio->professional_title }}</p>
                @if ($portfolio->resume_url)
                    <div class="stk-hero-actions">
                        <a href="{{ $portfolio->resume_url }}" target="_blank" rel="noopener" class="stk-btn stk-btn--red">Download R&eacute;sum&eacute;</a>
                    </div>
                @endif
            </div>
        </header>

        {{-- About + contact --}}
        <div class="stk-grid-2-1">
            <section class="stk-card">
                <h2 class="stk-card-title">About</h2>
                <p class="stk-text">{{ $portfolio->about }}</p>
            </section>

            <section class="stk-card">
                <h2 class="stk-card-title">Comm Link</h2>
                <div class="stk-field">
                    <span class="stk-field-label">Email</span>
                    <a href="mailto:{{ $portfolio->email }}" class="stk-field-value stk-link">{{ $portfolio->email }}</a>
                </div>
                <div class="stk-field">
                    <span class="stk-field-label">Phone</span>
                    <span class="stk-field-value">{{ $portfolio->contact_number }}</span>
                </div>
                @if ($portfolio->address)
                    <div class="stk-field">
                        <span class="stk-field-label">Location</span>
                        <span class="stk-field-value">{{ $portfolio->address }}</span>
                    </div>
                @endif
                @if (count($socials))
                    <div class="stk-socials">
                        @foreach ($socials as $platform => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="stk-btn stk-btn--cyan stk-btn--sm">{{ \App\Support\ViewHelpers::socialLabel($platform) }}</a>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>

        {{-- Skills --}}
        @if ($portfolio->skills->count())
            <section class="stk-card">
                <h2 class="stk-card-title">Suit Systems // Skills</h2>
                <div class="stk-chips">
                    @foreach ($portfolio->skills as $i => $skill)
                        <span class="stk-chip"><i aria-hidden="true"></i>{{ $skill->skill_name }}</span>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Projects --}}
        @if ($portfolio->projects->count())
            <h2 class="stk-section-title">Engineering Projects</h2>
            <div class="stk-grid-2">
                @foreach ($portfolio->projects as $i => $project)
                    <article class="stk-card stk-card--red stk-project">
                        <p class="stk-project-tag">Project {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</p>
                        <h3 class="stk-h3">{{ $project->project_name }}</h3>
                        @if ($project->description)<p class="stk-muted">{{ $project->description }}</p>@endif
                        @if ($project->technologyList())
                            <div class="stk-tech-row">
                                @foreach ($project->technologyList() as $tech)
                                    <span class="stk-tech">{{ $tech }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="stk-actions">
                            @if ($project->github_link)<a href="{{ $project->github_link }}" target="_blank" rel="noopener noreferrer" class="stk-btn stk-btn--cyan stk-btn--sm">Source</a>@endif
                            @if ($project->demo_link)<a href="{{ $project->demo_link }}" target="_blank" rel="noopener noreferrer" class="stk-btn stk-btn--red stk-btn--sm">Live Demo</a>@endif
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

        {{-- Experience / education --}}
        @if ($portfolio->experiences->count() || $portfolio->educations->count())
            <div class="stk-grid-2">
                @if ($portfolio->experiences->count())
                    <section class="stk-card stk-card--red">
                        <h2 class="stk-card-title">Mission Log</h2>
                        <ol class="stk-timeline">
                            @foreach ($portfolio->experiences as $job)
                                <li>
                                    <p class="stk-time">{{ $job->period() }}</p>
                                    <h3 class="stk-h4">{{ $job->position }}</h3>
                                    <p class="stk-sub">{{ $job->company }}</p>
                                    @if ($job->description)<p class="stk-desc">{{ $job->description }}</p>@endif
                                </li>
                            @endforeach
                        </ol>
                    </section>
                @endif

                @if ($portfolio->educations->count())
                    <section class="stk-card">
                        <h2 class="stk-card-title">Training History</h2>
                        <ol class="stk-timeline stk-timeline--cyan">
                            @foreach ($portfolio->educations as $edu)
                                <li>
                                    <p class="stk-time">{{ $edu->year_started }} &ndash; {{ $edu->year_graduated ?? 'Present' }}</p>
                                    <h3 class="stk-h4">{{ $edu->school }}</h3>
                                    <p class="stk-sub">{{ $edu->degree }}</p>
                                </li>
                            @endforeach
                        </ol>
                    </section>
                @endif
            </div>
        @endif

        {{-- Certifications / languages / interests in one card --}}
        @if ($certs || $languages || $interests)
            <section class="stk-card stk-card--gold">
                <div class="stk-grid-3">
                    @if ($certs)
                        <div>
                            <h2 class="stk-card-title">Certifications</h2>
                            <ul class="stk-list">@foreach ($certs as $cert)<li>{{ $cert }}</li>@endforeach</ul>
                        </div>
                    @endif
                    @if ($languages)
                        <div>
                            <h2 class="stk-card-title">Languages</h2>
                            <p class="stk-muted" style="margin:0;color:#cbd5e1">{{ implode(', ', $languages) }}</p>
                        </div>
                    @endif
                    @if ($interests)
                        <div>
                            <h2 class="stk-card-title">Interests</h2>
                            <p class="stk-muted" style="margin:0;color:#cbd5e1">{{ implode(', ', $interests) }}</p>
                        </div>
                    @endif
                </div>
            </section>
        @endif
    </div>
</div>