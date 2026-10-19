@props([
    'value',
    'label',
    'decimals' => 0,
    'prefix' => null,
    'suffix' => null,
    'source' => null,
    'size' => 'lg',
])

@inject('formatter', 'App\Support\Localization\LocaleFormatter')

{{-- The final value is server-rendered in the page language, so it is right without JS and with reduced motion; motion.js only counts up to it. --}}
<div {{ $attributes->class(['flex flex-col']) }}>
    <p @class([
        'font-display font-semibold leading-none text-navy tabular on-dark:text-white',
        'text-display-lg' => $size === 'lg',
        'text-display-md' => $size === 'md',
    ])>@if ($prefix)<span class="mr-0.5 text-[0.55em] font-medium align-[0.32em]">{{ $prefix }}</span>@endif<span data-count-to="{{ $value }}" data-count-decimals="{{ $decimals }}">{{ $formatter->number($value, decimals: $decimals) }}</span>@if ($suffix)<span class="ml-0.5 text-[0.55em] font-medium">{{ $suffix }}</span>@endif</p>
    <p class="mt-3 leading-snug text-ink on-dark:text-white/85">{{ $label }}</p>
    @if ($source)
        <p class="mt-2 text-xs leading-snug text-ink-soft on-dark:text-white/70">{{ $formatter->digits($source) }}</p>
    @endif
</div>
