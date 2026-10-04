{{-- CSS-drawn thumbnail that hints at each template's look (no image files needed) --}}
@props(['template'])
<div {{ $attributes->merge(['class' => 'relative aspect-[4/3] w-full overflow-hidden rounded-2xl']) }} aria-hidden="true">
    @if ($template === 'simple')
        {{-- Minimal white layout with a sidebar profile --}}
        <div class="flex h-full bg-white ring-1 ring-inset ring-slate-200">
            <div class="flex w-1/3 flex-col items-center gap-2 bg-slate-100 p-3">
                <div class="h-9 w-9 rounded-full bg-slate-300"></div>
                <div class="h-1.5 w-12 rounded bg-slate-400"></div>
                <div class="h-1.5 w-9 rounded bg-slate-300"></div>
                <div class="mt-2 h-1 w-10 rounded bg-slate-300"></div>
                <div class="h-1 w-10 rounded bg-slate-300"></div>
            </div>
            <div class="flex-1 space-y-2 p-4">
                <div class="h-2 w-1/3 rounded bg-slate-800"></div>
                <div class="h-1 w-full rounded bg-slate-200"></div>
                <div class="h-1 w-5/6 rounded bg-slate-200"></div>
                <div class="mt-3 h-2 w-1/4 rounded bg-slate-800"></div>
                <div class="h-1 w-full rounded bg-slate-200"></div>
                <div class="h-1 w-2/3 rounded bg-slate-200"></div>
            </div>
        </div>
    @elseif ($template === 'modern')
        {{-- Dark glass cards with a gradient button --}}
        <div class="h-full bg-slate-900 p-4">
            <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-indigo-500/40 blur-2xl"></div>
            <div class="absolute -bottom-6 left-4 h-24 w-24 rounded-full bg-fuchsia-500/30 blur-2xl"></div>
            <div class="relative space-y-2">
                <div class="h-2.5 w-1/2 rounded bg-white/80"></div>
                <div class="h-1.5 w-1/3 rounded bg-indigo-300/70"></div>
                <div class="mt-3 grid grid-cols-2 gap-2">
                    <div class="h-14 rounded-xl border border-white/10 bg-white/10"></div>
                    <div class="h-14 rounded-xl border border-white/10 bg-white/10"></div>
                </div>
                <div class="mt-1 h-5 w-20 rounded-full bg-gradient-to-r from-indigo-500 to-fuchsia-500"></div>
            </div>
        </div>
    @else
        {{-- Colorful hero banner with a timeline --}}
        <div class="h-full bg-white">
            <div class="h-1/3 bg-gradient-to-r from-fuchsia-500 via-orange-400 to-amber-300"></div>
            <div class="relative space-y-3 p-4 pl-8">
                <div class="absolute bottom-3 left-5 top-3 w-0.5 bg-gradient-to-b from-fuchsia-400 to-amber-300"></div>
                <div class="relative"><span class="absolute -left-[22px] top-0 h-2.5 w-2.5 rounded-full bg-fuchsia-500"></span><div class="h-2 w-1/2 rounded bg-slate-800"></div><div class="mt-1 h-1 w-3/4 rounded bg-slate-200"></div></div>
                <div class="relative"><span class="absolute -left-[22px] top-0 h-2.5 w-2.5 rounded-full bg-orange-400"></span><div class="h-2 w-2/5 rounded bg-slate-800"></div><div class="mt-1 h-1 w-2/3 rounded bg-slate-200"></div></div>
            </div>
        </div>
    @endif
</div>
