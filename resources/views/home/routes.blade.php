@inject('map', 'App\Support\Maps\Equirectangular')

@php
    $routeStats = $page->stats('routes')->keyBy('key');
    $formatter = $page->formatter();
    $balance = $page->tradeBalance();

    $seaPath = $map->smoothPath([[22.33, 91.83], [15, 88.5], [5, 80], [-10, 62], [-30, 40], [-36, 20], [-31, -8], [-23.96, -46.33]]);
    $airLegOne = $map->arc([23.84, 90.4], [25.25, 55.36], 0.22);
    $airLegTwo = $map->arc([25.25, 55.36], [-23.43, -46.47], 0.14);
    $dubai = $map->point(25.25, 55.36);

    $places = [
        ['key' => 'dhaka', 'lat' => 23.84, 'lon' => 90.4, 'align' => 'right', 'tone' => 'sun'],
        ['key' => 'chattogram', 'lat' => 22.33, 'lon' => 91.83, 'align' => 'below', 'tone' => 'sun'],
        ['key' => 'sao_paulo', 'lat' => -23.43, 'lon' => -46.47, 'align' => 'left', 'tone' => 'yellow'],
        ['key' => 'santos', 'lat' => -23.96, 'lon' => -46.33, 'align' => 'below', 'tone' => 'yellow'],
    ];

    $sides = [
        ['title' => __('home.routes.bd_sells'), 'items' => __('home.routes.bd_items'), 'stat' => $routeStats->get('bangladesh-to-brazil'), 'dot' => 'bg-sun'],
        ['title' => __('home.routes.br_sells'), 'items' => __('home.routes.br_items'), 'stat' => $routeStats->get('brazil-to-bangladesh'), 'dot' => 'bg-yellow'],
    ];
@endphp

{{-- Two-way trade: the balance today, and the routes the goods take (they draw themselves; a ship and a plane travel them). --}}
<section data-section="routes" data-tone="midnight" class="relative isolate overflow-hidden bg-midnight py-20 text-white md:py-28">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(60%_50%_at_50%_60%,rgb(36_86_214/0.22),transparent_70%)]" aria-hidden="true"></div>

    <div class="container-site">
        <div class="grid gap-12 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] lg:items-end">
            <x-ui.heading :eyebrow="__('home.routes.eyebrow')" :title="__('home.routes.title')" :lead="__('home.routes.lead')" size="lg" />

            <div data-reveal>
                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach ($sides as $side)
                        <div class="rounded-2xl bg-white/[0.05] p-5 ring-1 ring-white/10">
                            <p class="flex items-center gap-2 text-sm font-semibold text-white/70">
                                <span class="size-2.5 rounded-full {{ $side['dot'] }}" aria-hidden="true"></span>{{ $side['title'] }}
                            </p>
                            @if ($side['stat'])
                                <p class="mt-3 font-display text-display-sm leading-none font-bold tabular">
                                    {{ $side['stat']->prefix }}{{ $formatter->number($side['stat']->value, decimals: $side['stat']->decimals) }}{{ $side['stat']->suffix }}
                                </p>
                                <p class="mt-1 text-xs text-white/50">{{ $formatter->digits($side['stat']->source.', '.$side['stat']->as_of) }}</p>
                            @endif
                            <p class="mt-3 text-sm leading-relaxed text-white/80">{{ $side['items'] }}</p>
                        </div>
                    @endforeach
                </div>

                @if ($balance)
                    <div class="mt-5" data-draw>
                        <div class="flex h-3 overflow-hidden rounded-full bg-white/10" role="img" aria-label="{{ __('home.routes.balance', ['share' => $formatter->plain((int) round($balance['bangladesh']))]) }}">
                            <span class="balance-bar h-full rounded-l-full bg-sun" style="--share: {{ $balance['bangladesh'] }}%"></span>
                            <span class="balance-bar h-full bg-yellow" style="--share: {{ $balance['brazil'] }}%"></span>
                        </div>
                        <p class="mt-3 text-sm leading-relaxed text-white/70">{{ __('home.routes.balance', ['share' => $formatter->plain((int) round($balance['bangladesh']))]) }}</p>
                    </div>
                @endif
            </div>
        </div>

        <figure class="relative mt-14 md:mt-20">
            <div class="relative aspect-[1000/380] w-full" role="img" aria-label="{{ __('home.routes.map_label') }}" data-draw>
                <img src="{{ asset('img/world-dots.svg') }}" alt="" width="1000" height="380" loading="lazy" decoding="async" class="absolute inset-0 size-full select-none">

                <svg viewBox="0 0 1000 380" class="absolute inset-0 size-full overflow-visible" aria-hidden="true" focusable="false">
                    <path id="route-sea" data-route="sea" d="{{ $seaPath }}" fill="none" stroke="#ffdf00" stroke-width="2.4" stroke-linecap="round" class="route-draw" />
                    <g data-route="air" fill="none" stroke="#3ddc97" stroke-width="1.8" stroke-linecap="round">
                        <path id="route-air-1" d="{{ $airLegOne }}" class="route-draw" />
                        <path id="route-air-2" d="{{ $airLegTwo }}" class="route-draw" />
                    </g>
                    <circle cx="{{ $dubai['x'] }}" cy="{{ $dubai['y'] }}" r="3.5" fill="#3ddc97" />

                    {{-- Travellers: started by motion.js only when motion is allowed. --}}
                    <g class="route-traveller-svg">
                        <circle r="5" fill="#ffdf00" stroke="#071a33" stroke-width="2">
                            <animateMotion dur="14s" repeatCount="indefinite" begin="indefinite" rotate="auto"><mpath href="#route-sea" /></animateMotion>
                        </circle>
                        <circle r="4" fill="#3ddc97" stroke="#071a33" stroke-width="2">
                            <animateMotion dur="5s" repeatCount="indefinite" begin="indefinite"><mpath href="#route-air-2" /></animateMotion>
                        </circle>
                    </g>
                </svg>

                @foreach ($places as $place)
                    @php($point = $map->point($place['lat'], $place['lon']))
                    <div class="absolute" style="left: {{ round($point['x'] / 10, 3) }}%; top: {{ round($point['y'] / 3.8, 3) }}%">
                        <span @class([
                            'absolute size-3 -translate-x-1/2 -translate-y-1/2 rounded-full',
                            'bg-sun shadow-[0_0_0_5px_rgb(232_40_63/0.3)]' => $place['tone'] === 'sun',
                            'bg-yellow shadow-[0_0_0_5px_rgb(255_223_0/0.3)]' => $place['tone'] === 'yellow',
                        ])></span>
                        <span @class([
                            'absolute rounded-md bg-midnight/85 px-1.5 py-0.5 text-[0.65rem] font-semibold whitespace-nowrap text-white ring-1 ring-white/10 sm:text-xs',
                            'left-3 -translate-y-1/2' => $place['align'] === 'right',
                            'right-3 -translate-y-1/2' => $place['align'] === 'left',
                            'top-2.5 -translate-x-1/2' => $place['align'] === 'below',
                        ])>{{ __("home.routes.{$place['key']}") }}</span>
                    </div>
                @endforeach
            </div>

            <figcaption class="mt-10 grid gap-4 text-sm text-white/80 sm:grid-cols-2">
                <span class="flex items-start gap-4 rounded-2xl bg-white/[0.04] p-4 ring-1 ring-white/10">
                    <span class="grid size-10 shrink-0 place-items-center rounded-full bg-yellow text-navy"><x-ui.icon name="ship" class="size-5" /></span>
                    <span><strong class="block font-semibold text-white">{{ __('home.routes.sea') }}</strong> {{ __('home.routes.sea_detail') }}</span>
                </span>
                <span class="flex items-start gap-4 rounded-2xl bg-white/[0.04] p-4 ring-1 ring-white/10">
                    <span class="grid size-10 shrink-0 place-items-center rounded-full bg-mint text-navy"><x-ui.icon name="plane" class="size-5" /></span>
                    <span><strong class="block font-semibold text-white">{{ __('home.routes.air') }}</strong> {{ __('home.routes.air_detail') }}</span>
                </span>
            </figcaption>
        </figure>
    </div>
</section>
