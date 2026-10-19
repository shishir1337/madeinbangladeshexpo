@php
    $city = $page->edition()?->venue?->cityName();
    $documentTitle = $page->title().($city ? " · {$city}" : '');
@endphp

<x-layouts.site :title="$documentTitle" :description="__('home.meta_description')" :image-alt="__('home.hero.photo_main')" overlay-header>
    @push('head')
        <x-seo.json-ld :data="$page->structuredData($settings)" />
        <link rel="preload" as="image" type="image/avif" imagesrcset="{{ collect([480, 800, 1200])->map(fn (int $width): string => asset("img/expo25-stand-garments-{$width}.avif")." {$width}w")->implode(', ') }}" imagesizes="(min-width: 1024px) 22rem, 62vw" fetchpriority="high">
    @endpush

    @include('home.hero')
    @include('home.ticket')
    @include('home.paths')
    @include('home.why')
    @include('home.routes')
    @include('home.sectors')
    @include('home.programme')
    @include('home.where')
    @include('home.editions')
    @include('home.highlights')
    @include('home.timeline')
    @include('home.press')
    @include('home.partners')
    @include('home.cta')
</x-layouts.site>
