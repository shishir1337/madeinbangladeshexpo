@props([
    'href' => null,
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconStart' => null,
    'type' => 'button',
])

@php
    $classes = [
        'group/button relative inline-flex select-none items-center justify-center gap-2 rounded-full font-semibold whitespace-nowrap transition duration-200 ease-out active:translate-y-px disabled:pointer-events-none disabled:opacity-50',
        match ($variant) {
            'secondary' => 'bg-white/70 text-navy ring-1 ring-inset ring-navy/25 hover:bg-white hover:ring-navy/60',
            'ghost' => 'text-navy hover:bg-navy-50',
            'highlight' => 'bg-yellow text-navy shadow-[0_8px_20px_-10px_rgb(184_160_0/0.9)] hover:bg-[#ffe84d]',
            'on-dark' => 'bg-white/10 text-white ring-1 ring-inset ring-white/25 backdrop-blur hover:bg-white/20 hover:ring-white/50',
            'light' => 'bg-white text-navy shadow-soft hover:bg-cream',
            default => 'bg-green text-white shadow-[inset_0_1px_0_rgb(255_255_255/0.12),0_10px_24px_-12px_rgb(0_79_58/0.85)] hover:bg-green-700',
        },
        match ($size) {
            'sm' => 'h-10 px-4 text-sm',
            'lg' => 'h-14 px-7 text-base',
            default => 'h-12 px-6 text-[0.95rem]',
        },
    ];

    $iconClass = $size === 'sm' ? 'size-4' : 'size-[1.15rem]';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
        @if ($iconStart)
            <x-ui.icon :name="$iconStart" :class="$iconClass" />
        @endif
        <span>{{ $slot }}</span>
        @if ($icon)
            <x-ui.icon :name="$icon" :class="$iconClass.' transition-transform duration-300 group-hover/button:translate-x-0.5'" />
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>
        @if ($iconStart)
            <x-ui.icon :name="$iconStart" :class="$iconClass" />
        @endif
        <span>{{ $slot }}</span>
        @if ($icon)
            <x-ui.icon :name="$icon" :class="$iconClass.' transition-transform duration-300 group-hover/button:translate-x-0.5'" />
        @endif
    </button>
@endif
