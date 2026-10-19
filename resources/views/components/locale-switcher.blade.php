@inject('localizedUrls', 'App\Support\Localization\LocalizedUrls')

@php($links = $localizedUrls->switcher())

@if ($links !== [])
    <nav aria-label="{{ __('site.language') }}" {{ $attributes }}>
        <ul>
            @foreach ($links as $link)
                <li>
                    <a href="{{ $link['url'] }}" hreflang="{{ $link['locale']->hreflang }}" lang="{{ $link['locale']->htmlLang }}" @if ($link['isCurrent']) aria-current="true" @endif>
                        {{ $link['locale']->nativeName }}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
@endif
