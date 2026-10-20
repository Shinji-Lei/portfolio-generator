{{-- Progress steps for the portfolio flow.
     Usage: <x-steps :current="2" />
       1 = Preview template is the current step
       2 = Information is the current step (step 1 shows as done)
       3 = Success is the current step
       4 = everything finished (all three steps show green)
     Options: variant="gradient" for the indigo/violet strip, "compact" to drop the bottom margin. --}}
@props(['current' => 1, 'variant' => 'dark', 'compact' => false])
@php
    $steps = [1 => 'Preview template', 2 => 'Information', 3 => 'Success'];
@endphp

{{-- Step styles (plain CSS, so no Tailwind rebuild is needed) --}}
<style>
    .steps-done   { color: #6ee7b7; }
    .steps-done > span { background: rgba(16, 185, 129, 0.22); color: #6ee7b7; }
    .steps-active { color: #c7d2fe; }
    .steps-active > span { background: linear-gradient(90deg, #4f46e5, #7c3aed); color: #ffffff; }
    .steps-next   { color: #94a3b8; }
    .steps-next > span { background: rgba(255, 255, 255, 0.09); }
    .steps-line { background: rgba(255, 255, 255, 0.22); }
    .steps-line-done { background: rgba(16, 185, 129, 0.6); }

    /* Variant for sitting on a bright gradient: white text, solid green for finished steps */
    .steps-gradient .steps-done { color: #ffffff; }
    .steps-gradient .steps-done > span { background: #10b981; color: #ffffff; }
    .steps-gradient .steps-active { color: #ffffff; }
    .steps-gradient .steps-active > span { background: #ffffff; color: #4f46e5; }
    .steps-gradient .steps-next { color: rgba(255, 255, 255, 0.75); }
    .steps-gradient .steps-next > span { background: rgba(255, 255, 255, 0.2); color: #ffffff; }
    .steps-gradient .steps-line { background: rgba(255, 255, 255, 0.4); }
    .steps-gradient .steps-line-done { background: rgba(255, 255, 255, 0.9); }

    .steps-compact { margin-bottom: 0 !important; }
</style>

<ol class="{{ $variant === 'gradient' ? 'steps-gradient' : '' }} {{ $compact ? 'steps-compact' : '' }} mx-auto mb-10 flex max-w-xl flex-wrap items-center justify-center gap-2 text-sm font-medium" aria-label="Progress">
    @foreach ($steps as $number => $label)
        @php $state = $number < $current ? 'done' : ($number === $current ? 'active' : 'next'); @endphp
        <li class="steps-{{ $state }} flex items-center gap-2" @if ($state === 'active') aria-current="step" @endif>
            <span class="flex h-7 w-7 items-center justify-center rounded-full">
                @if ($state === 'done')
                    <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 10.5l3.5 3.5 7.5-8" /></svg>
                    <span class="sr-only">Completed:</span>
                @else
                    {{ $number }}
                @endif
            </span>
            {{ $label }}
        </li>
        @if (! $loop->last)
            <li class="{{ $number < $current ? 'steps-line-done' : 'steps-line' }} h-px w-8" aria-hidden="true"></li>
        @endif
    @endforeach
</ol>