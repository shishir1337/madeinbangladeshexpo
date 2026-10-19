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
        <div class="container-site flex h-16 items-center gap-3 transition-[height] duration-300 sm:gap-4 lg:gap-6 xl:gap-10" x-bind:class="scrolled ? 'lg:h-16' : 'lg:h-20'">
            <x-site.logo class="xl:shrink-0" />

            @if ($groups !== [] || $contact)
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
                                        'inline-flex items-center gap-1.5 rounded-full px-3 py-2 text-[0.94rem] font-medium whitespace-nowrap transition-colors hover:bg-sand/60 xl:px-3.5',
                                        'text-navy' => $group['active'],
                                        'text-ink' => ! $group['active'],
                                    ])
                                    x-bind:class="open === '{{ $group['key'] }}' && '!bg-white text-navy shadow-ring'"
                                >
                                    {{ $group['label'] }}
                                    <x-ui.icon name="chevron-down" class="size-4 opacity-60 transition-transform duration-300" x-bind:class="open === '{{ $group['key'] }}' && 'rotate-180'" />
                                </button>
                                <x-site.mega-menu :group="$group" />
                            </li>
                        @endforeach

                        @if ($contact)
                            <li>
                                <a
                                    href="{{ $contact['url'] }}"
                                    @if ($contact['active']) aria-current="page" @endif
                                    @class([
                                        'inline-flex rounded-full px-3 py-2 text-[0.94rem] font-medium whitespace-nowrap transition-colors hover:bg-sand/60 xl:px-3.5',
                                        'text-navy' => $contact['active'],
                                        'text-ink' => ! $contact['active'],
                                    ])
                                >{{ $contact['label'] }}</a>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif

            <div class="ml-auto flex shrink-0 items-center gap-1.5 sm:gap-2">
                <x-locale-switcher />

                @if ($shell->navigation->has('register'))
                    <x-ui.button :href="localized_route('register')" variant="secondary" size="sm" class="max-2xl:hidden">
                        {{ __('site.cta.register') }}
                    </x-ui.button>
                @endif

                @if ($shell->navigation->has('apply'))
                    <x-ui.button :href="localized_route('apply')" size="sm" class="max-xl:hidden">
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
                        class="-mr-1 grid size-11 place-items-center rounded-full text-navy transition hover:bg-sand/60 xl:hidden"
                    >
                        <x-ui.icon name="menu" class="size-6" />
                        <span class="sr-only">{{ __('nav.menu') }}</span>
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if ($groups !== [] || $contact)
        <x-site.drawer :groups="$groups" :contact="$contact" />
    @endif
</header>
