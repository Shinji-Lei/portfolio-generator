{{-- CSS-drawn thumbnail that hints at each template's look (no image files needed) --}}
@props(['template'])

{{-- Dark glassmorphism styles (plain CSS so no Tailwind rebuild is needed) --}}
@once
    <style>
        .tt { background: #060913; border: 1px solid rgba(255, 255, 255, 0.08); }

        /* Soft colored light blobs behind the glass */
        .tt-glow { position: absolute; border-radius: 9999px; filter: blur(30px); pointer-events: none; }
        .tt-glow-indigo  { background: rgba(99, 102, 241, 0.55); }
        .tt-glow-violet  { background: rgba(139, 92, 246, 0.45); }
        .tt-glow-fuchsia { background: rgba(217, 70, 239, 0.40); }
        .tt-glow-orange  { background: rgba(251, 146, 60, 0.35); }
        .tt-glow-slate   { background: rgba(148, 163, 184, 0.28); }

        /* Frosted glass panel */
        .tt-glass {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        /* Placeholder text lines */
        .tt-line   { height: 4px; border-radius: 4px; background: rgba(255, 255, 255, 0.14); }
        .tt-title  { height: 7px; border-radius: 4px; background: rgba(255, 255, 255, 0.80); }
        .tt-accent { height: 5px; border-radius: 4px; background: rgba(165, 180, 252, 0.70); }

        .tt-avatar { background: linear-gradient(135deg, rgba(255, 255, 255, 0.35), rgba(255, 255, 255, 0.10)); border: 1px solid rgba(255, 255, 255, 0.18); }
        .tt-pill   { background: linear-gradient(90deg, #6366f1, #d946ef); box-shadow: 0 4px 14px rgba(99, 102, 241, 0.45); }
        .tt-banner { background: linear-gradient(90deg, #d946ef, #fb923c, #fcd34d); opacity: 0.92; }
        .tt-rail   { background: linear-gradient(180deg, #e879f9, #fcd34d); }
        .tt-dot-a  { background: #d946ef; box-shadow: 0 0 10px rgba(217, 70, 239, 0.9); }
        .tt-dot-b  { background: #fb923c; box-shadow: 0 0 10px rgba(251, 146, 60, 0.9); }
    </style>
@endonce

<div {{ $attributes->merge(['class' => 'tt relative aspect-[4/3] w-full overflow-hidden rounded-2xl']) }} aria-hidden="true">
    @if ($template === 'simple')
        {{-- Minimal layout with a frosted sidebar profile --}}
        <div class="tt-glow tt-glow-slate -left-6 -top-6 h-24 w-24"></div>
        <div class="tt-glow tt-glow-indigo -bottom-8 right-0 h-24 w-24" style="opacity: .6"></div>
        <div class="relative flex h-full">
            <div class="tt-glass flex w-1/3 flex-col items-center gap-2 p-3" style="border-width: 0 1px 0 0;">
                <div class="tt-avatar h-9 w-9 rounded-full"></div>
                <div class="tt-line w-12" style="background: rgba(255,255,255,.45)"></div>
                <div class="tt-line w-9"></div>
                <div class="tt-line mt-2 w-10"></div>
                <div class="tt-line w-10"></div>
            </div>
            <div class="flex-1 space-y-2 p-4">
                <div class="tt-title w-1/3"></div>
                <div class="tt-line w-full"></div>
                <div class="tt-line w-5/6"></div>
                <div class="tt-title mt-3 w-1/4"></div>
                <div class="tt-line w-full"></div>
                <div class="tt-line w-2/3"></div>
            </div>
        </div>
    @elseif ($template === 'modern')
        {{-- Glass cards with a gradient button --}}
        <div class="tt-glow tt-glow-indigo -right-6 -top-6 h-24 w-24"></div>
        <div class="tt-glow tt-glow-fuchsia -bottom-6 left-4 h-24 w-24"></div>
        <div class="relative h-full space-y-2 p-4">
            <div class="tt-title w-1/2" style="height: 9px"></div>
            <div class="tt-accent w-1/3"></div>
            <div class="mt-3 grid grid-cols-2 gap-2">
                <div class="tt-glass h-14 rounded-xl"></div>
                <div class="tt-glass h-14 rounded-xl"></div>
            </div>
            <div class="tt-pill mt-1 h-5 w-20 rounded-full"></div>
        </div>
    @else
        {{-- Colorful glowing banner with a glass timeline card --}}
        <div class="tt-glow tt-glow-fuchsia -left-4 -top-4 h-20 w-28"></div>
        <div class="tt-glow tt-glow-orange -bottom-8 right-2 h-24 w-24"></div>
        <div class="relative h-full">
            <div class="tt-banner h-1/3"></div>
            <div class="tt-glass relative mx-3 -mt-3 space-y-3 rounded-xl p-4 pl-8">
                <div class="tt-rail absolute bottom-3 left-5 top-3 w-0.5"></div>
                <div class="relative"><span class="tt-dot-a absolute -left-[22px] top-0 h-2.5 w-2.5 rounded-full"></span><div class="tt-title w-1/2"></div><div class="tt-line mt-1 w-3/4"></div></div>
                <div class="relative"><span class="tt-dot-b absolute -left-[22px] top-0 h-2.5 w-2.5 rounded-full"></span><div class="tt-title w-2/5"></div><div class="tt-line mt-1 w-2/3"></div></div>
            </div>
        </div>
    @endif
</div>