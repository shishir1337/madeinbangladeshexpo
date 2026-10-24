@props([
    'overlay' => false,
])

@inject('shell', 'App\View\SiteShell')

@php
    $groups = $shell->navigation->primary();
    $account = $shell->navigation->account();
@endphp

{{--
    The header keeps one height (nothing reflows while scrolling). With `overlay` it starts transparent over a dark
    hero and turns solid once the page scrolls or a menu opens; colours come from the --hdr-* variables.
--}}
<header
    x-data="siteHeader(@js($overlay))"
    x-on:keydown.escape.window="closeAll()"
    x-on:click.outside="closeAll(false)"
    data-overlay="{{ $overlay ? 'true' : 'false' }}"
    x-bind:data-overlay="(overlay && ! scrolled && open === null && ! drawer).toString()"
    class="site-header sticky top-0 z-40"
>
    <div class="header-bar relative border-b">
        <div class="container-site flex h-16 items-center gap-3 sm:gap-4 lg:h-[4.5rem] lg:gap-6">
            <x-site.logo class="xl:shrink-0" />

            @if ($groups !== [])
                {{-- Each mega-menu panel follows its trigger inside the navigation, so Tab moves trigger → panel → next trigger. --}}
                <nav aria-label="{{ __('nav.main') }}" class="hidden xl:block">
                    <ul class="flex items-center gap-0.5">
                        @foreach ($groups as $group)
                            <li x-on:focusout="if (open === '{{ $group['key'] }}' && ! $el.contains($event.relatedTarget)) closeAll(false)">
                                <button
                                    type="button"
                                    x-ref="trigger-{{ $group['key'] }}"
                                    x-on:click="toggle('{{ $group['key'] }}')"
                                    x-on:keydown.down.prevent="openAndFocus('{{ $group['key'] }}')"
                                    aria-expanded="false"
                                    x-bind:aria-expanded="(open === '{{ $group['key'] }}').toString()"
                                    aria-controls="mega-{{ $group['key'] }}"
                                    @class([
                                        'header-link inline-flex items-center gap-1 rounded-full px-2.5 py-2 text-[0.92rem] font-medium whitespace-nowrap 2xl:px-3',
                                        'is-active' => $group['active'],
                                    ])
                                    x-bind:class="open === '{{ $group['key'] }}' && 'is-open'"
                                >
                                    {{ $group['label'] }}
                                    <x-ui.icon name="chevron-down" class="size-4 opacity-60 transition-transform duration-300" x-bind:class="open === '{{ $group['key'] }}' && 'rotate-180'" />
                                </button>
                                <x-site.mega-menu :group="$group" />
                            </li>
                        @endforeach

                    </ul>
                </nav>
            @endif

            <div class="ml-auto flex shrink-0 items-center gap-1.5 sm:gap-2">
                <x-locale-switcher />

                @if ($account)
                    <a
                        href="{{ $account['url'] }}"
                        @if ($account['active']) aria-current="page" @endif
                        class="header-pill inline-flex h-10 items-center gap-2 rounded-full px-2.5 text-sm font-semibold max-sm:hidden sm:px-3"
                    >
                        <x-ui.icon name="log-in" class="size-4" />
                        <span class="max-xl:sr-only">{{ $account['label'] }}</span>
                    </a>
                @endif


                @if ($shell->navigation->has('apply'))
                    <x-ui.button :href="localized_route('apply')" size="sm" class="header-cta max-xl:hidden">
                        {{ __('site.cta.apply') }}
                    </x-ui.button>
                @endif

                @if ($groups !== [])
                    <button
                        type="button"
                        x-ref="drawerButton"
                        x-on:click="openDrawer()"
                        aria-expanded="false"
                        x-bind:aria-expanded="drawer.toString()"
                        aria-controls="site-drawer"
                        class="header-link -mr-1 grid size-11 place-items-center rounded-full xl:hidden"
                    >
                        <x-ui.icon name="menu" class="size-6" />
                        <span class="sr-only">{{ __('nav.menu') }}</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if ($groups !== [])
        <x-site.drawer :groups="$groups" :account="$account" />
    @endif
</header>
