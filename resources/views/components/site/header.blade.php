@inject('shell', 'App\View\SiteShell')

@php
    $groups = $shell->navigation->primary();
    $contact = $shell->navigation->contact();
@endphp

<header
    x-data="siteHeader"
    x-on:keydown.escape.window="closeAll()"
    x-on:click.outside="closeAll(false)"
    class="sticky top-0 z-40"
>
    <div
        class="relative border-b border-transparent bg-cream/75 backdrop-blur-md transition-[background-color,border-color] duration-300"
        x-bind:class="(scrolled || open) && '!border-sand !bg-cream/95 backdrop-blur-xl'"
    >
        <div class="container-site flex h-16 items-center gap-4 transition-[height] duration-300 lg:gap-6 xl:gap-10" x-bind:class="scrolled ? 'lg:h-16' : 'lg:h-20'">
            <x-site.logo />

            @if ($groups !== [] || $contact)
                <nav aria-label="{{ __('nav.main') }}" class="hidden lg:block">
                    <ul class="flex items-center gap-0.5">
                        @foreach ($groups as $group)
                            <li>
                                <button
                                    type="button"
                                    x-ref="trigger-{{ $group['key'] }}"
                                    x-on:click="toggle('{{ $group['key'] }}')"
                                    aria-expanded="false"
                                    x-bind:aria-expanded="(open === '{{ $group['key'] }}').toString()"
                                    aria-controls="mega-{{ $group['key'] }}"
                                    @class([
                                        'inline-flex items-center gap-1.5 rounded-full px-3.5 py-2 text-[0.94rem] font-medium transition-colors hover:bg-sand/60',
                                        'text-navy' => $group['active'],
                                        'text-ink' => ! $group['active'],
                                    ])
                                    x-bind:class="open === '{{ $group['key'] }}' && '!bg-white text-navy shadow-ring'"
                                >
                                    {{ $group['label'] }}
                                    <x-ui.icon name="chevron-down" class="size-4 opacity-60 transition-transform duration-300" x-bind:class="open === '{{ $group['key'] }}' && 'rotate-180'" />
                                </button>
                            </li>
                        @endforeach

                        @if ($contact)
                            <li>
                                <a
                                    href="{{ $contact['url'] }}"
                                    @if ($contact['active']) aria-current="page" @endif
                                    @class([
                                        'inline-flex rounded-full px-3.5 py-2 text-[0.94rem] font-medium transition-colors hover:bg-sand/60',
                                        'text-navy' => $contact['active'],
                                        'text-ink' => ! $contact['active'],
                                    ])
                                >{{ $contact['label'] }}</a>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif

            <div class="ml-auto flex items-center gap-2">
                <x-locale-switcher />

                @if ($shell->navigation->has('register'))
                    <x-ui.button :href="localized_route('register')" variant="secondary" size="sm" class="hidden md:inline-flex">
                        {{ __('site.cta.register') }}
                    </x-ui.button>
                @endif

                @if ($shell->navigation->has('apply'))
                    <x-ui.button :href="localized_route('apply')" size="sm" class="hidden sm:inline-flex">
                        {{ __('site.cta.apply') }}
                    </x-ui.button>
                @endif

                @if ($groups !== [] || $contact)
                    <button
                        type="button"
                        x-ref="drawerButton"
                        x-on:click="openDrawer()"
                        aria-expanded="false"
                        x-bind:aria-expanded="drawer.toString()"
                        aria-controls="site-drawer"
                        class="-mr-1 grid size-11 place-items-center rounded-full text-navy transition hover:bg-sand/60 lg:hidden"
                    >
                        <x-ui.icon name="menu" class="size-6" />
                        <span class="sr-only">{{ __('nav.menu') }}</span>
                    </button>
                @endif
            </div>
        </div>

        @foreach ($groups as $group)
            <x-site.mega-menu :group="$group" />
        @endforeach
    </div>

    @if ($groups !== [] || $contact)
        <x-site.drawer :groups="$groups" :contact="$contact" />
    @endif
</header>
