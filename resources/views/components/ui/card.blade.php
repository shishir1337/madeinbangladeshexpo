@props([
    'href' => null,
    'tone' => 'white',
    'padding' => 'md',
])

@php
    $classes = [
        'group/card relative block overflow-hidden rounded-[var(--radius-card)] transition duration-300 ease-out',
        match ($tone) {
            'cream' => 'bg-cream ring-1 ring-sand',
            'midnight' => 'bg-midnight text-white ring-1 ring-white/10',
            'green' => 'bg-green text-white',
            'yellow' => 'bg-yellow text-navy',
            default => 'bg-white shadow-soft ring-1 ring-ink/5',
        },
        match ($padding) {
            'none' => '',
            'sm' => 'p-5',
            'lg' => 'p-8 md:p-10',
            default => 'p-6 md:p-7',
        },
        'hover:-translate-y-1 hover:shadow-lift focus-visible:-translate-y-1' => $href,
    ];
@endphp

@if ($href)
    <a href="{{ $href }}" data-tone="{{ $tone }}" {{ $attributes->class($classes) }}>{{ $slot }}</a>
@else
    <div data-tone="{{ $tone }}" {{ $attributes->class($classes) }}>{{ $slot }}</div>
@endif
