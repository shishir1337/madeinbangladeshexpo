@props([
    'group',
])

@inject('shell', 'App\View\SiteShell')

<div
    id="mega-{{ $group['key'] }}"
    x-show="open === '{{ $group['key'] }}'"
    x-cloak
    x-transition:enter="transition duration-300 ease-out"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition duration-150 ease-in"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="absolute inset-x-0 top-full hidden xl:block"
>
    <div class="container-site pt-2 pb-6">
        <div class="grid overflow-hidden rounded-[1.75rem] bg-white shadow-lift ring-1 ring-ink/5 lg:grid-cols-[minmax(0,1fr)_19rem] xl:grid-cols-[minmax(0,1fr)_21rem]">
            <div class="p-6 xl:p-8">
                <p class="eyebrow">{{ $group['label'] }}</p>
                <ul
                    class="mt-4 grid gap-1 xl:grid-cols-2"
                    x-on:keydown.down.prevent="$focus.wrap().next()"
                    x-on:keydown.up.prevent="$focus.wrap().previous()"
                >
                    @foreach ($group['items'] as $item)
                        <li>
                            <a
                                href="{{ $item['url'] }}"
                                @if ($item['active']) aria-current="page" @endif
                                class="group/item flex items-start gap-4 rounded-2xl p-3 transition-colors hover:bg-cream focus-visible:bg-cream"
                            >
                                <span @class([
                                    'grid size-11 shrink-0 place-items-center rounded-xl transition-colors duration-300',
                                    'bg-green text-white' => $item['active'],
                                    'bg-green-50 text-green group-hover/item:bg-green group-hover/item:text-white' => ! $item['active'],
                                ])>
                                    <x-ui.icon :name="$item['icon']" class="size-5" />
                                </span>
                                <span class="min-w-0 pt-0.5">
                                    <span class="flex items-center gap-1.5 font-semibold text-navy">
                                        {{ $item['label'] }}
                                        <x-ui.icon name="arrow-right" class="size-4 -translate-x-1 opacity-0 transition duration-300 group-hover/item:translate-x-0 group-hover/item:opacity-100" />
                                    </span>
                                    <span class="mt-0.5 block text-sm leading-snug text-ink-soft">{{ $item['description'] }}</span>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <aside
                data-tone="midnight"
                class="relative isolate flex flex-col overflow-hidden bg-midnight p-6 text-white xl:p-8"
                style="--motif-1: #3ddc97; --motif-2: #ffdf00; --motif-3: #ffffff"
            >
                <x-ui.motif variant="tiles" class="absolute inset-0 -z-10 opacity-[0.09]" />
                <div class="absolute -right-16 -bottom-16 -z-10 size-56 rounded-full bg-green/60 blur-3xl"></div>

                @if ($edition = $shell->edition())
                    <p class="eyebrow !text-mint">{{ __('site.next_edition') }}</p>
                    <p class="mt-3 font-display text-2xl font-semibold leading-tight text-white">{{ $edition->name }}</p>
                    <ul class="mt-5 space-y-2.5 text-sm text-white/80">
                        <li class="flex items-start gap-2.5">
                            <x-ui.icon name="calendar" class="mt-0.5 size-4 text-yellow" />
                            <span class="tabular">{{ $shell->dateRange() }}</span>
                        </li>
                        @if ($venue = $shell->venueLine())
                            <li class="flex items-start gap-2.5">
                                <x-ui.icon name="map-pin" class="mt-0.5 size-4 text-yellow" />
                                <span>{{ $venue }}</span>
                            </li>
                        @endif
                    </ul>
                    @if ($days = $shell->daysToGoLabel())
                        <p class="mt-5 inline-flex w-fit items-center gap-2 rounded-full bg-white/10 px-3 py-1.5 text-sm font-medium ring-1 ring-white/15">
                            <span class="size-2 rounded-full bg-mint animate-pulse-dot" aria-hidden="true"></span>
                            {{ $days }}
                        </p>
                    @endif
                    @if ($shell->navigation->has('register'))
                        <div class="mt-auto pt-6">
                            <x-ui.button :href="localized_route('register')" variant="highlight" size="sm" icon="arrow-right">
                                {{ __('site.announcement.register') }}
                            </x-ui.button>
                        </div>
                    @endif
                @else
                    <p class="font-display text-xl font-semibold">{{ __('site.brand') }}</p>
                    <p class="mt-2 text-sm text-white/70">{{ __('site.dates_to_be_announced') }}</p>
                @endif
            </aside>
        </div>
    </div>
</div>
