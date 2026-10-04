{{-- White card that groups related form fields under a title --}}
@props(['title', 'description' => null, 'icon' => null])
<section {{ $attributes->merge(['class' => 'rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-8']) }}>
    <div class="mb-6 flex items-start gap-3">
        @if ($icon)
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                <x-icon :name="$icon" class="h-5 w-5" />
            </span>
        @endif
        <div>
            <h2 class="text-lg font-semibold text-slate-900">{{ $title }}</h2>
            @if ($description)<p class="text-sm text-slate-500">{{ $description }}</p>@endif
        </div>
    </div>
    {{ $slot }}
</section>
