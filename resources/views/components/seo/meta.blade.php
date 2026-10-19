@props([
    'title',
    'description' => null,
    'image' => null,
    'type' => 'website',
])

@inject('locales', 'App\Support\Localization\Locales')

{{-- Canonical, Open Graph and Twitter tags for every page. --}}
<link rel="canonical" href="{{ url()->current() }}">
<meta property="og:type" content="{{ $type }}">
<meta property="og:site_name" content="{{ __('site.brand') }}">
<meta property="og:title" content="{{ $title }}">
@if ($description)
    <meta property="og:description" content="{{ $description }}">
@endif
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:locale" content="{{ $currentLocale->icu }}">
@foreach ($locales->all() as $locale)
    @if ($locale->key !== $currentLocale->key)
        <meta property="og:locale:alternate" content="{{ $locale->icu }}">
    @endif
@endforeach
@if ($image)
    <meta property="og:image" content="{{ $image }}">
    <meta property="og:image:alt" content="{{ $title }}">
@endif
<meta name="twitter:card" content="summary_large_image">
