@props([
    'title',
    'description' => null,
    'smooth' => false,
])

@inject('shell', 'App\View\SiteShell')

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
    <meta name="theme-color" content="#004F3A">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preload" href="{{ asset('fonts/anek-bangla-latin-wght.woff2') }}" as="font" type="font/woff2" crossorigin>
    @if ($currentLocale->key === 'bn')
        <link rel="preload" href="{{ asset('fonts/anek-bangla-bengali-wght.woff2') }}" as="font" type="font/woff2" crossorigin>
    @endif
    <x-seo.alternates />
    {{-- Before first paint: JS flag, motion preference (stored, else the OS setting) and a dismissed announcement. --}}
    <script>(function(d){d.classList.add('js');try{var m=localStorage.getItem('mbe.motion');if(!m&&matchMedia('(prefers-reduced-motion: reduce)').matches){m='reduced'}if(m){d.dataset.motion=m}var announcementKey=d.dataset.announcementKey;if(announcementKey&&localStorage.getItem(announcementKey)==='dismissed'){d.classList.add('announcement-dismissed')}}catch(e){}})(document.documentElement)</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans text-ink bg-cream min-h-dvh flex flex-col" @if ($smooth) data-smooth @endif>
    <a id="skip-to-content" href="#main" class="skip-link">{{ __('site.skip_to_content') }}</a>

    <x-demo-ribbon />
    <x-site.announcement />
    <x-site.header />

    <main id="main" tabindex="-1" class="flex-1 outline-none">
        {{ $slot }}
    </main>

    <x-site.footer />
    <x-site.help-button />

    @livewireScriptConfig
</body>
</html>
