@props([
    'items',
])

@php
    $jsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => collect($items)->values()->map(fn (array $item, int $index): array => array_filter([
            '@type' => 'ListItem',
            'position' => $index + 1,
            'name' => $item['label'],
            'item' => $item['url'] ?? null,
        ]))->all(),
    ];
@endphp

<nav aria-label="{{ __('site.breadcrumb') }}" {{ $attributes }}>
    <ol class="flex flex-wrap items-center gap-x-1.5 gap-y-1 text-sm text-ink-soft on-dark:text-white/70">
        @foreach ($items as $item)
            <li class="flex items-center gap-1.5">
                @unless ($loop->first)
                    <x-ui.icon name="chevron-right" class="size-3.5 opacity-50" />
                @endunless
                @if ($loop->last)
                    <span aria-current="page" class="font-medium text-ink on-dark:text-white">{{ $item['label'] }}</span>
                @else
                    <a href="{{ $item['url'] }}" class="link-underline transition-colors hover:text-navy on-dark:hover:text-white">{{ $item['label'] }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
<script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}</script>
