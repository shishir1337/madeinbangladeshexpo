@props(['title'])

<!DOCTYPE html>
<html lang="{{ $currentLocale->htmlLang }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <x-seo.alternates />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <x-locale-switcher />
    </header>

    {{ $slot }}
</body>
</html>
