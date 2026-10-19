@inject('localizedUrls', 'App\Support\Localization\LocalizedUrls')

@foreach ($localizedUrls->alternates() as $hreflang => $url)
    <link rel="alternate" hreflang="{{ $hreflang }}" href="{{ $url }}">
@endforeach
