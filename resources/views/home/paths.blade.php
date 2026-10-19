@inject('navigation', 'App\Support\Navigation\SiteNavigation')
@inject('formatter', 'App\Support\Localization\LocaleFormatter')

@php
    $firstExisting = fn (string ...$routes): ?string => collect($routes)->first(fn (string $route): bool => $navigation->has($route));

    $cards = [
        ['key' => 'exhibit', 'icon' => 'store', 'route' => $firstExisting('apply', 'exhibit'), 'tone' => 'bg-green text-white', 'dark' => true, 'accent' => 'text-yellow'],
        ['key' => 'buyer', 'icon' => 'shopping-bag', 'route' => $firstExisting('register', 'visit'), 'tone' => 'bg-yellow text-navy', 'dark' => false, 'accent' => 'text-navy'],
        ['key' => 'delegate', 'icon' => 'plane', 'route' => $firstExisting('register'), 'tone' => 'bg-midnight text-white', 'dark' => true, 'accent' => 'text-mint'],
        ['key' => 'sponsor', 'icon' => 'sparkles', 'route' => $firstExisting('sponsorship', 'press'), 'tone' => 'bg-white text-ink', 'dark' => false, 'accent' => 'text-crimson'],
    ];
@endphp

{{-- Four ways in, as garment swing tags: each hangs from its punched hole and swings a little on hover. --}}
<x-ui.section tone="cream" data-section="paths" id="take-part" class="!pt-6 md:!pt-10">
    <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(0,0.8fr)] lg:items-end">
        <x-ui.heading :eyebrow="__('home.paths.eyebrow')" :title="__('home.paths.title')" size="lg" />
        <p class="max-w-md text-lead text-ink-soft lg:justify-self-end" data-reveal>{{ __('home.paths.lead') }}</p>
    </div>

    <ul class="mt-14 grid gap-x-5 gap-y-12 pt-6 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($cards as $card)
            <li class="relative" data-reveal>
                {{-- The string the tag hangs from. --}}
                <svg class="absolute -top-7 left-1/2 h-10 w-6 -translate-x-1/2 text-ink/35" viewBox="0 0 24 40" fill="none" aria-hidden="true" focusable="false">
                    <path d="M12 0c0 10 6 14 0 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
                <article
                    @if ($card['dark']) data-tone="{{ $card['key'] === 'exhibit' ? 'green' : 'midnight' }}" @endif
                    @class([
                        'swing-tag group relative flex h-full flex-col overflow-hidden rounded-[1.4rem] px-7 pt-12 pb-7 shadow-lift',
                        $card['tone'],
                        'ring-1 ring-ink/5' => $card['key'] === 'sponsor',
                    ])
                    style="--hole-bg: var(--color-cream)"
                >
                    <span class="swing-tag-hole absolute top-4 left-1/2 -translate-x-1/2" aria-hidden="true"></span>
                    <x-ui.icon :name="$card['icon']" class="pointer-events-none absolute -right-6 -bottom-6 size-40 opacity-[0.08] transition-transform duration-700 group-hover:-rotate-6 group-hover:scale-110" />

                    <p class="flex items-center justify-between font-display text-sm font-semibold tracking-[0.14em] uppercase opacity-70">
                        <span>{{ $formatter->plain(0) }}{{ $formatter->plain($loop->iteration) }}</span>
                        <x-ui.icon :name="$card['icon']" @class(['size-6 opacity-100', $card['accent']]) />
                    </p>
                    <h3 @class(['mt-5 font-display text-[1.9rem] leading-[1.05] font-bold tracking-[-0.02em]', 'text-white' => $card['dark'], 'text-navy' => ! $card['dark']])>{{ __("home.paths.{$card['key']}.title") }}</h3>
                    <p class="mt-2 text-sm font-medium opacity-75">{{ __("home.paths.{$card['key']}.who") }}</p>

                    <ul class="mt-6 space-y-2.5 text-[0.95rem] leading-snug">
                        @foreach (__("home.paths.{$card['key']}.points") as $point)
                            <li class="flex gap-2.5">
                                <x-ui.icon name="check" @class(['mt-0.5 size-4', $card['accent']]) />
                                <span>{{ $point }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <div class="relative mt-auto pt-8">
                        @php($href = $card['route'] ? localized_route($card['route']) : localized_route('home').'#updates')
                        <a href="{{ $href }}" @class([
                            'inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-semibold transition after:absolute after:inset-0 after:rounded-[1.4rem] group-hover:gap-3',
                            'bg-white/15 text-white ring-1 ring-white/25 group-hover:bg-white group-hover:text-navy' => $card['dark'],
                            'bg-navy text-white group-hover:bg-green' => ! $card['dark'],
                        ])>
                            {{ $card['route'] ? __("home.paths.{$card['key']}.cta") : __('home.paths.cta_interest') }}
                            <x-ui.icon :name="$card['route'] ? 'arrow-right' : 'arrow-down'" class="size-4" />
                        </a>
                    </div>
                </article>
            </li>
        @endforeach
    </ul>
</x-ui.section>
