@inject('localizedUrls', 'App\Support\Localization\LocalizedUrls')

@php($links = $localizedUrls->switcher())

@if ($links !== [])
    <div
        x-data="{ open: false }"
        x-on:keydown.escape.stop="open = false; $refs.button.focus()"
        x-on:click.outside="open = false"
        x-on:focusout="if (! $el.contains($event.relatedTarget)) open = false"
        class="relative"
    >
        <button
            type="button"
            x-ref="button"
            x-on:click="open = ! open"
            aria-expanded="false"
            x-bind:aria-expanded="open.toString()"
            aria-controls="language-menu"
            class="inline-flex h-10 items-center gap-1 rounded-full px-2.5 text-sm font-semibold text-ink ring-1 ring-inset ring-sand transition hover:bg-white sm:gap-1.5 sm:px-3"
        >
            <x-ui.icon name="globe" class="size-4 max-sm:hidden" />
            <span lang="{{ $currentLocale->htmlLang }}">{{ $currentLocale->shortName }}</span>
            <x-ui.icon name="chevron-down" class="size-3.5 opacity-60 transition-transform" x-bind:class="open && 'rotate-180'" />
            <span class="sr-only">{{ __('site.language') }}</span>
        </button>

        <nav
            id="language-menu"
            aria-label="{{ __('site.language') }}"
            x-show="open"
            x-cloak
            x-transition.origin.top.right
            {{ $attributes->class(['absolute right-0 top-full z-50 mt-2 w-52 rounded-2xl bg-white p-1.5 shadow-lift ring-1 ring-ink/5']) }}
        >
            <ul>
                @foreach ($links as $link)
                    <li>
                        <a href="{{ $link['url'] }}" hreflang="{{ $link['locale']->hreflang }}" lang="{{ $link['locale']->htmlLang }}" @if ($link['isCurrent']) aria-current="true" @endif class="flex items-center justify-between gap-3 rounded-xl px-3 py-2.5 text-[0.95rem] text-ink transition-colors hover:bg-cream aria-[current=true]:font-semibold aria-[current=true]:text-navy">{{ $link['locale']->nativeName }}@if ($link['isCurrent'])<x-ui.icon name="check" class="size-4 text-green" />@endif</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
@endif
