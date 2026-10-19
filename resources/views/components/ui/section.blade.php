@props([
    'tone' => 'cream',
    'spacing' => 'md',
    'container' => true,
])

<section
    data-tone="{{ $tone }}"
    {{ $attributes->class([
        'relative isolate',
        match ($tone) {
            'white' => 'bg-white',
            'sand' => 'bg-cream-2',
            'midnight' => 'bg-midnight text-white',
            'green' => 'bg-green text-white',
            default => 'bg-cream',
        },
        match ($spacing) {
            'none' => '',
            'sm' => 'py-12 md:py-16',
            'lg' => 'py-20 md:py-32',
            default => 'py-16 md:py-24',
        },
    ]) }}
>
    @if ($container)
        <div class="container-site">{{ $slot }}</div>
    @else
        {{ $slot }}
    @endif
</section>
