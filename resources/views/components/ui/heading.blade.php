@props([
    'eyebrow' => null,
    'title',
    'lead' => null,
    'align' => 'start',
    'level' => 2,
    'size' => 'md',
])

<div {{ $attributes->class([
    'max-w-3xl',
    'mx-auto text-center' => $align === 'center',
]) }}>
    @if ($eyebrow)
        <p @class(['eyebrow flex items-center gap-3 on-dark:text-mint', 'justify-center' => $align === 'center']) data-reveal>
            <span class="stitch-x w-7 shrink-0 opacity-60" aria-hidden="true"></span>{{ $eyebrow }}
        </p>
    @endif

    <h{{ $level }} @class([
        'font-display text-navy on-dark:text-white',
        'mt-4' => $eyebrow,
        'text-display-xl font-bold tracking-[-0.03em]' => $size === 'xl',
        'text-display-lg font-bold tracking-[-0.025em]' => $size === 'lg',
        'text-display-md font-semibold' => $size === 'md',
        'text-display-sm font-semibold' => $size === 'sm',
    ]) data-reveal>{{ $title }}</h{{ $level }}>

    @if ($lead)
        <p class="mt-5 text-lead text-ink-soft on-dark:text-white/75" data-reveal>{{ $lead }}</p>
    @endif

    {{ $slot }}
</div>
