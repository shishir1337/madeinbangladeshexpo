@props([
    'variant' => 'jamdani',
    'size' => null,
])

{{--
    The brand motif (spec §6): Jamdani weaving crossed with Brazilian modernist tilework. Never a literal flag.
    Colour comes from currentColor (jamdani, band) or the --motif-1/2/3 variables (tiles), so one motif
    works on cream and on midnight. Each instance gets its own pattern id.
--}}
@php
    $patternId = 'motif-'.$variant.'-'.\Illuminate\Support\Str::lower(\Illuminate\Support\Str::random(8));
    $tile = $size ?? match ($variant) {
        'tiles' => 64,
        'band' => 24,
        default => 48,
    };
@endphp

<svg {{ $attributes->merge(['class' => 'pointer-events-none select-none']) }} aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
    <defs>
        @switch($variant)
            @case('tiles')
                <pattern id="{{ $patternId }}" width="{{ $tile }}" height="{{ $tile }}" patternUnits="userSpaceOnUse" viewBox="0 0 64 64">
                    {{-- Athos Bulcão-style module: four 32px tiles, each a rotation of quarter-circle, triangle and bar. --}}
                    <rect width="32" height="32" fill="var(--motif-bg, transparent)" />
                    <path d="M0 32 A32 32 0 0 1 32 0 L32 32 Z" fill="var(--motif-1, currentColor)" />
                    <path d="M32 0 H64 V32 Z" fill="var(--motif-2, currentColor)" opacity=".85" />
                    <circle cx="48" cy="48" r="9" fill="var(--motif-3, currentColor)" />
                    <path d="M0 64 V48 A16 16 0 0 1 16 32 H32 V64 Z" fill="var(--motif-2, currentColor)" opacity=".55" />
                    <rect x="36" y="36" width="4" height="24" fill="var(--motif-1, currentColor)" opacity=".7" />
                </pattern>
                @break

            @case('band')
                <pattern id="{{ $patternId }}" width="{{ $tile }}" height="{{ $tile }}" patternUnits="userSpaceOnUse" viewBox="0 0 24 24">
                    {{-- A stepped "tera" border from Jamdani saris: one stair-stepped peak per 24px. --}}
                    <path d="M0 24 V18 H3 V15 H6 V12 H9 V9 H12 V6 H15 V9 H18 V12 H21 V15 H24 V24 Z" fill="currentColor" />
                    <rect x="11" y="18" width="2" height="2" fill="var(--motif-bg, #fbf7ee)" />
                </pattern>
                @break

            @default
                <pattern id="{{ $patternId }}" width="{{ $tile }}" height="{{ $tile }}" patternUnits="userSpaceOnUse" viewBox="0 0 48 48">
                    {{-- Jamdani buti: a stepped lozenge around a smooth diamond, on a dotted lattice. --}}
                    <path d="M21 6h6v3h3v3h3v3h3v3h3v3h3v6h-3v3h-3v3h-3v3h-3v3h-3v3h-6v-3h-3v-3h-3v-3h-3v-3H9v-3H6v-6h3v-3h3v-3h3v-3h3V9h3Z" fill="none" stroke="currentColor" stroke-width="1.25" opacity=".55" />
                    <path d="M24 16 32 24 24 32 16 24Z" fill="currentColor" opacity=".35" />
                    <circle cx="0" cy="0" r="1.6" fill="currentColor" opacity=".5" />
                    <circle cx="48" cy="0" r="1.6" fill="currentColor" opacity=".5" />
                    <circle cx="0" cy="48" r="1.6" fill="currentColor" opacity=".5" />
                    <circle cx="48" cy="48" r="1.6" fill="currentColor" opacity=".5" />
                </pattern>
        @endswitch
    </defs>
    <rect width="100%" height="100%" fill="url(#{{ $patternId }})" />
</svg>
