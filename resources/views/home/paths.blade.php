@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php
    $firstExisting = fn (string ...$routes): ?string => collect($routes)->first(fn (string $route): bool => $navigation->has($route));

    $cards = [
        ['key' => 'exhibit', 'icon' => 'store', 'route' => $firstExisting('apply', 'exhibit')],
        ['key' => 'buyer', 'icon' => 'shopping-bag', 'route' => $firstExisting('register', 'visit')],
        ['key' => 'delegate', 'icon' => 'plane', 'route' => $firstExisting('register')],
        ['key' => 'sponsor', 'icon' => 'sparkles', 'route' => $firstExisting('sponsorship', 'press')],
    ];
@endphp

<x-ui.section tone="cream" data-section="paths" id="take-part">
    <x-ui.heading :eyebrow="__('home.paths.eyebrow')" :title="__('home.paths.title')" :lead="__('home.paths.lead')" />

    <div class="mt-12 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($cards as $card)
            <article
                data-reveal
                data-reveal-delay="{{ $loop->index * 0.07 }}"
                @class([
                    'group relative flex flex-col rounded-[1.75rem] p-7 transition duration-300 hover:-translate-y-1 hover:shadow-lift',
                    'bg-green text-white shadow-lift' => $loop->first,
                    'bg-white shadow-soft ring-1 ring-ink/5' => ! $loop->first,
                ])
                @if ($loop->first) data-tone="green" @endif
            >
                <span @class([
                    'grid size-12 place-items-center rounded-2xl',
                    'bg-white/15 text-yellow' => $loop->first,
                    'bg-green-50 text-green' => ! $loop->first,
                ])>
                    <x-ui.icon :name="$card['icon']" class="size-6" />
                </span>
                <h3 class="mt-6 font-display text-2xl font-semibold text-navy on-dark:text-white">{{ __("home.paths.{$card['key']}.title") }}</h3>
                <p class="mt-1 text-sm font-medium text-ink-soft on-dark:text-white/70">{{ __("home.paths.{$card['key']}.who") }}</p>
                <ul class="mt-5 space-y-2.5 text-[0.95rem] leading-snug">
                    @foreach (__("home.paths.{$card['key']}.points") as $point)
                        <li class="flex gap-2.5">
                            <x-ui.icon name="check" class="mt-0.5 size-4 text-green on-dark:text-mint" />
                            <span>{{ $point }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-auto pt-7">
                    @if ($card['route'])
                        <x-ui.link :href="localized_route($card['route'])" class="after:absolute after:inset-0 after:rounded-[1.75rem]">{{ __("home.paths.{$card['key']}.cta") }}</x-ui.link>
                    @else
                        <x-ui.link :href="localized_route('home').'#updates'" icon="arrow-down" class="after:absolute after:inset-0 after:rounded-[1.75rem]">{{ __('home.paths.cta_interest') }}</x-ui.link>
                    @endif
                </div>
            </article>
        @endforeach
    </div>
</x-ui.section>
