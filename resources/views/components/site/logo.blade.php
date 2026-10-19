@props([
    'tone' => 'light',
])

@inject('shell', 'App\View\SiteShell')

@php($city = $shell->edition()?->venue?->city)

<a
    href="{{ localized_route('home') }}"
    {{ $attributes->class(['group inline-flex shrink-0 items-center gap-3 rounded-xl']) }}
    aria-label="{{ __('site.brand') }}, {{ __('site.home') }}"
>
    {{-- The expo mark echoes BBCCI's logo (a diamond for Brazil, discs for the two flags) on the expo's bottle green. --}}
    <svg class="size-10 shrink-0 transition-transform duration-500 ease-out group-hover:-rotate-6" viewBox="0 0 40 40" aria-hidden="true" focusable="false">
        <rect width="40" height="40" rx="11" fill="#004F3A" />
        <path d="M20 5.5 34.5 20 20 34.5 5.5 20Z" fill="#FFDF00" />
        <circle cx="16.4" cy="17.4" r="7.2" fill="#B3122A" />
        <circle cx="22.4" cy="21.9" r="7.4" fill="#002776" />
    </svg>
    <span class="flex flex-col">
        <span @class([
            'font-display text-[1.02rem] font-semibold leading-none tracking-tight sm:text-[1.08rem]',
            'text-navy' => $tone === 'light',
            'text-white' => $tone === 'dark',
        ])>{{ __('site.brand') }}</span>
        @if ($city)
            <span @class([
                'mt-1 text-[0.7rem] font-semibold uppercase leading-none tracking-[0.16em]',
                'text-ink-soft' => $tone === 'light',
                'text-white/60' => $tone === 'dark',
            ])>{{ $city }}@if ($year = $shell->editionYear()) · {{ $year }}@endif</span>
        @endif
    </span>
</a>
