@props([
    'title',
    'description' => null,
    'image' => 'expo25-stand-garments',
    'imageAlt' => null,
    'overlayHeader' => false,
    'noindex' => false,
])

@inject('shell', 'App\View\SiteShell')
@inject('images', 'App\Support\Images\ImageManifest')

@php
    $announcementKey = $shell->edition() ? 'mbe.announcement.'.$shell->edition()->slug : null;
@endphp

<!DOCTYPE html>
<html lang="{{ $currentLocale->htmlLang }}" @if ($announcementKey) data-announcement-key="{{ $announcementKey }}" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $title }}</title>
    @if ($description)
        <meta name="description" content="{{ $description }}">
    @endif
    @if ($noindex)
        <meta name="robots" content="noindex, follow">
    @endif
    <meta name="theme-color" content="#004F3A">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preload" href="{{ asset('fonts/anek-bangla-latin-wght.woff2') }}" as="font" type="font/woff2" crossorigin>
    @if ($currentLocale->key === 'bn')
        <link rel="preload" href="{{ asset('fonts/anek-bangla-bengali-wght.woff2') }}" as="font" type="font/woff2" crossorigin>
    @endif
    <x-seo.meta :title="$title" :description="$description" :image="$images->url($image)" :image-alt="$imageAlt" />
    <x-seo.alternates />
    @stack('head')
    {{-- Before first paint: JS flag, motion preference (stored, else the OS setting) and a dismissed announcement. --}}
    <script>(function(d){d.classList.add('js');try{var m=localStorage.getItem('mbe.motion');if(!m&&matchMedia('(prefers-reduced-motion: reduce)').matches){m='reduced'}if(m){d.dataset.motion=m}var announcementKey=d.dataset.announcementKey;if(announcementKey&&localStorage.getItem(announcementKey)==='dismissed'){d.classList.add('announcement-dismissed')}}catch(e){}})(document.documentElement)</script>
    {{-- Chrome and Edge prerender a page when the pointer rests on its link, so it opens instantly. --}}
    <script type="speculationrules">{"prerender":[{"where":{"and":[{"href_matches":"/*"},{"not":{"selector_matches":"[target], [download], [rel~=nofollow], [data-no-prerender]"}}]},"eagerness":"moderate"}]}</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans text-ink bg-cream min-h-dvh flex flex-col">
    <a id="skip-to-content" href="#main" class="skip-link">{{ __('site.skip_to_content') }}</a>

    <x-demo-ribbon />
    <x-site.announcement />
    <x-site.header :overlay="$overlayHeader" />

    <main id="main" tabindex="-1" class="flex-1 outline-none">
        {{ $slot }}
    </main>

    <x-site.footer />
    <x-site.help-button />

    @livewireScriptConfig
</body>
</html>
