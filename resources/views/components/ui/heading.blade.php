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
        <p class="eyebrow on-dark:text-mint" data-reveal>{{ $eyebrow }}</p>
    @endif

    <h{{ $level }} @class([
        'font-display font-semibold text-navy on-dark:text-white',
        'mt-3' => $eyebrow,
        'text-display-lg' => $size === 'lg',
        'text-display-md' => $size === 'md',
        'text-display-sm' => $size === 'sm',
    ]) data-reveal>{{ $title }}</h{{ $level }}>

    @if ($lead)
        <p class="mt-4 text-lead text-ink-soft on-dark:text-white/75" data-reveal data-reveal-delay="0.08">{{ $lead }}</p>
    @endif

    {{ $slot }}
</div>
