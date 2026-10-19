@props([
    'title',
    'description' => null,
    'smooth' => true,
])

<!DOCTYPE html>
<html lang="{{ $currentLocale->htmlLang }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $title }}</title>
    @if ($description)
        <meta name="description" content="{{ $description }}">
    @endif
    <meta name="theme-color" content="#004F3A">
    <x-seo.alternates />
    <script>document.documentElement.classList.add('js');try{var m=localStorage.getItem('mbe.motion');if(m){document.documentElement.dataset.motion=m}}catch(e){}</script>
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
