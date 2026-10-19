@props([
    'groups',
    'account' => null,
])

@inject('shell', 'App\View\SiteShell')

<div
    id="site-drawer"
    x-show="drawer"
    x-cloak
    x-trap.inert.noscroll="drawer"
    x-on:keydown.escape.stop="closeDrawer()"
    role="dialog"
    aria-modal="true"
    aria-label="{{ __('nav.menu') }}"
    class="fixed inset-0 z-50 xl:hidden"
>
    <div
        x-show="drawer"
        x-transition.opacity.duration.300ms
        x-on:click="closeDrawer()"
        class="absolute inset-0 bg-midnight/45 backdrop-blur-sm"
        aria-hidden="true"
    ></div>

    <div
        x-show="drawer"
        x-transition:enter="transition duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition duration-200 ease-in"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="absolute inset-y-0 right-0 flex w-full max-w-md flex-col bg-cream shadow-lift"
    >
        <div class="flex h-16 shrink-0 items-center justify-between gap-4 border-b border-sand px-4 sm:px-6">
            <x-site.logo />
            <button
                type="button"
                x-on:click="closeDrawer()"
                class="-mr-1 grid size-11 place-items-center rounded-full text-navy transition hover:bg-sand/60"
            >
                <x-ui.icon name="x" class="size-6" />
                <span class="sr-only">{{ __('nav.close_menu') }}</span>
            </button>
        </div>

        <nav aria-label="{{ __('nav.menu') }}" class="flex-1 overflow-y-auto overscroll-contain px-4 py-2 sm:px-6">
            <ul class="divide-y divide-sand">
                @foreach ($groups as $group)
                    <li x-data="{ expanded: {{ $group['active'] ? 'true' : 'false' }} }">
                        <button
                            type="button"
                            x-on:click="expanded = ! expanded"
                            aria-expanded="{{ $group['active'] ? 'true' : 'false' }}"
                            x-bind:aria-expanded="expanded.toString()"
                            class="flex w-full items-center justify-between gap-4 py-4 text-left font-display text-lg font-semibold text-navy"
                        >
                            {{ $group['label'] }}
                            <span class="grid size-8 place-items-center rounded-full bg-white shadow-ring transition-transform duration-300" x-bind:class="expanded && 'rotate-45'">
                                <x-ui.icon name="plus" class="size-4" />
                            </span>
                        </button>
                        <ul x-show="expanded" x-collapse @unless ($group['active']) x-cloak @endunless class="pb-3">
                            @foreach ($group['items'] as $item)
                                <li>
                                    <a
                                        href="{{ $item['url'] }}"
                                        @if ($item['active']) aria-current="page" @endif
                                        @class([
                                            'flex items-center gap-3 rounded-xl px-2 py-2.5 font-medium transition-colors hover:bg-white',
                                            'bg-white text-navy' => $item['active'],
                                        ])
                                    >
                                        <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-green-50 text-green">
                                            <x-ui.icon :name="$item['icon']" class="size-[1.1rem]" />
                                        </span>
                                        {{ $item['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach

                @if ($account)
                    <li>
                        <a href="{{ $account['url'] }}" @if ($account['active']) aria-current="page" @endif class="flex items-center justify-between py-4 font-display text-lg font-semibold text-navy">
                            {{ $account['label'] }}
                            <x-ui.icon name="log-in" class="size-5" />
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

        <div class="shrink-0 space-y-3 border-t border-sand bg-cream-2 px-4 pt-4 pb-[max(1rem,env(safe-area-inset-bottom))] sm:px-6">
            @if ($shell->navigation->has('apply') || $shell->navigation->has('register'))
                <div class="grid grid-cols-2 gap-2">
                    @if ($shell->navigation->has('register'))
                        <x-ui.button :href="localized_route('register')" variant="secondary">{{ __('site.cta.register') }}</x-ui.button>
                    @endif
                    @if ($shell->navigation->has('apply'))
                        <x-ui.button :href="localized_route('apply')">{{ __('site.cta.apply') }}</x-ui.button>
                    @endif
                </div>
            @endif
            <div class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-ink-soft">
                <a href="{{ $shell->telUrl() }}" class="inline-flex items-center gap-2 hover:text-navy">
                    <x-ui.icon name="phone" class="size-4" /> <span class="tabular">{{ $shell->settings->phone }}</span>
                </a>
                <a href="{{ $shell->whatsappUrl() }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 hover:text-navy">
                    <x-ui.icon name="whatsapp" class="size-4" /> {{ __('site.footer.whatsapp') }}
                </a>
            </div>
        </div>
    </div>
</div>
