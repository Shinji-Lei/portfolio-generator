{{-- Dark glass card that groups related form fields under a title --}}
@props(['title', 'description' => null, 'icon' => null])
<section {{ $attributes->merge(['class' => 'rounded-3xl border border-white/10 bg-gradient-to-br from-white/[0.07] to-white/[0.02] p-5 shadow-xl shadow-black/20 backdrop-blur sm:p-8']) }}>
    <div class="mb-6 flex items-start gap-3">
        @if ($icon)
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500/25 to-fuchsia-500/20 text-violet-300 ring-1 ring-inset ring-violet-400/30">
                <x-icon :name="$icon" class="h-5 w-5" />
            </span>
        @endif
        <div>
            <h2 class="text-lg font-semibold text-white">{{ $title }}</h2>
            @if ($description)<p class="text-sm text-slate-400">{{ $description }}</p>@endif
        </div>
    </div>
    {{ $slot }}
</section>