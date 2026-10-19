@props([
    'tone' => 'light',
])

@inject('shell', 'App\View\SiteShell')

@php
    $city = $shell->edition()?->venue?->cityName();
@endphp

<a
    href="{{ localized_route('home') }}"
    {{ $attributes->class(['group inline-flex min-w-0 items-center gap-2.5 rounded-xl sm:gap-3']) }}
    aria-label="{{ __('site.brand') }}, {{ __('site.home') }}"
>
    {{-- The expo mark echoes BBCCI's logo (a diamond for Brazil, discs for the two flags) on the expo's bottle green. --}}
    <svg class="size-9 shrink-0 transition-transform duration-500 ease-out group-hover:-rotate-6 sm:size-10" viewBox="0 0 40 40" aria-hidden="true" focusable="false">
        <rect width="40" height="40" rx="11" fill="#004F3A" />
        <path d="M20 5.5 34.5 20 20 34.5 5.5 20Z" fill="#FFDF00" />
        <circle cx="16.4" cy="17.4" r="7.2" fill="#B3122A" />
        <circle cx="22.4" cy="21.9" r="7.4" fill="#002776" />
    </svg>
    <span class="flex min-w-0 flex-col">
        <span @class([
            'max-w-[8.5rem] font-display text-[0.95rem] leading-[1.05] font-semibold tracking-tight sm:max-w-none sm:text-[1.08rem] sm:leading-none',
            'text-navy' => $tone === 'light',
            'text-white' => $tone === 'dark',
        ])>{{ __('site.brand') }}</span>
        @if ($city)
            <span @class([
                'mt-1 text-[0.7rem] leading-none font-semibold tracking-[0.16em] uppercase max-sm:hidden',
                'text-ink-soft' => $tone === 'light',
                'text-white/60' => $tone === 'dark',
            ])>{{ $city }}@if ($year = $shell->editionYear()) · {{ $year }}@endif</span>
        @endif
    </span>
</a>
