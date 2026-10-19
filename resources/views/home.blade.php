@php
    $city = $page->edition()?->venue?->cityName();
    $documentTitle = $page->title().($city ? " · {$city}" : '');
@endphp

<x-layouts.site :title="$documentTitle" :description="__('home.meta_description')" :image-alt="__('home.hero.photo_main')" smooth>
    @push('head')
        <x-seo.json-ld :data="$page->structuredData($settings)" />
    @endpush

    @include('home.hero')
    @include('home.countdown')
    @include('home.paths')
    @include('home.why')
    @include('home.routes')
    @include('home.sectors')
    @include('home.where')
    @include('home.timeline')
    @include('home.highlights')
    @include('home.press')
    @include('home.partners')
    @include('home.cta')
</x-layouts.site>
