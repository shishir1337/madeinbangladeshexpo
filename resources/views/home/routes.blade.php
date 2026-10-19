@inject('map', 'App\Support\Maps\Equirectangular')

@php
    $routeStats = $page->stats('routes')->keyBy('key');
    $formatter = $page->formatter();

    $seaPath = $map->smoothPath([[22.33, 91.83], [15, 88.5], [5, 80], [-10, 62], [-30, 40], [-36, 20], [-31, -8], [-23.96, -46.33]]);
    $airLegOne = $map->arc([23.84, 90.4], [25.25, 55.36], 0.22);
    $airLegTwo = $map->arc([25.25, 55.36], [-23.43, -46.47], 0.14);

    $places = [
        ['key' => 'dhaka', 'lat' => 23.84, 'lon' => 90.4, 'align' => 'right', 'tone' => 'crimson'],
        ['key' => 'chattogram', 'lat' => 22.33, 'lon' => 91.83, 'align' => 'below', 'tone' => 'crimson'],
        ['key' => 'sao_paulo', 'lat' => -23.43, 'lon' => -46.47, 'align' => 'left', 'tone' => 'yellow'],
        ['key' => 'santos', 'lat' => -23.96, 'lon' => -46.33, 'align' => 'below', 'tone' => 'yellow'],
    ];

    $sides = [
        ['title' => __('home.routes.bd_sells'), 'items' => __('home.routes.bd_items'), 'stat' => $routeStats->get('bangladesh-to-brazil'), 'dot' => 'bg-crimson'],
        ['title' => __('home.routes.br_sells'), 'items' => __('home.routes.br_items'), 'stat' => $routeStats->get('brazil-to-bangladesh'), 'dot' => 'bg-yellow'],
    ];
@endphp

<section data-section="routes" data-tone="midnight" class="relative isolate overflow-hidden bg-midnight py-16 text-white md:py-24">
    <div class="absolute top-1/3 left-1/2 -z-10 h-96 w-[70rem] -translate-x-1/2 rounded-full bg-navy/40 blur-3xl" aria-hidden="true"></div>

    <div class="container-site">
        <div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] lg:items-end">
            <x-ui.heading :eyebrow="__('home.routes.eyebrow')" :title="__('home.routes.title')" :lead="__('home.routes.lead')" />

            <div class="grid gap-3 sm:grid-cols-2">
                @foreach ($sides as $side)
                    <div class="rounded-2xl bg-white/[0.05] p-5 ring-1 ring-white/10" data-reveal data-reveal-delay="{{ $loop->index * 0.08 }}">
                        <p class="flex items-center gap-2 text-sm font-semibold text-white/70">
                            <span class="size-2.5 rounded-full {{ $side['dot'] }}" aria-hidden="true"></span>{{ $side['title'] }}
                        </p>
                        @if ($side['stat'])
                            <p class="mt-3 font-display text-display-sm leading-none font-semibold tabular">
                                {{ $side['stat']->prefix }}{{ $formatter->number($side['stat']->value, decimals: $side['stat']->decimals) }}{{ $side['stat']->suffix }}
                            </p>
                            <p class="mt-1 text-xs text-white/50">{{ $formatter->digits($side['stat']->source.', '.$side['stat']->as_of) }}</p>
                        @endif
                        <p class="mt-3 text-sm leading-relaxed text-white/80">{{ $side['items'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <figure class="relative mt-12 md:mt-16">
            <div class="relative aspect-[1000/380] w-full" role="img" aria-label="{{ __('home.routes.map_label') }}">
                <img src="{{ asset('img/world-dots.svg') }}" alt="" width="1000" height="380" loading="lazy" decoding="async" class="absolute inset-0 size-full select-none">

                <svg viewBox="0 0 1000 380" class="absolute inset-0 size-full overflow-visible" aria-hidden="true" focusable="false">
                    <path data-route="sea" d="{{ $seaPath }}" fill="none" stroke="#ffdf00" stroke-width="2.2" stroke-linecap="round" class="route-flow" />
                    <g data-route="air" fill="none" stroke="#3ddc97" stroke-width="1.8" stroke-linecap="round" stroke-dasharray="2 6">
                        <path d="{{ $airLegOne }}" class="route-flow-fast" />
                        <path d="{{ $airLegTwo }}" class="route-flow-fast" />
                    </g>
                    @php
                        $dubai = $map->point(25.25, 55.36);
                    @endphp
                    <circle cx="{{ $dubai['x'] }}" cy="{{ $dubai['y'] }}" r="3" fill="#3ddc97" />
                </svg>

                @foreach ($places as $place)
                    @php
                        $point = $map->point($place['lat'], $place['lon']);
                    @endphp
                    <div
                        class="absolute"
                        style="left: {{ round($point['x'] / 10, 3) }}%; top: {{ round($point['y'] / 3.8, 3) }}%"
                    >
                        <span @class([
                            'absolute size-3 -translate-x-1/2 -translate-y-1/2 rounded-full ring-4',
                            'bg-crimson ring-crimson/30' => $place['tone'] === 'crimson',
                            'bg-yellow ring-yellow/30' => $place['tone'] === 'yellow',
                        ])></span>
                        <span @class([
                            'absolute rounded-md bg-midnight/80 px-1.5 py-0.5 text-[0.65rem] font-semibold whitespace-nowrap text-white backdrop-blur sm:text-xs',
                            'left-3 -translate-y-1/2' => $place['align'] === 'right',
                            'right-3 -translate-y-1/2' => $place['align'] === 'left',
                            'top-2.5 -translate-x-1/2' => $place['align'] === 'below',
                        ])>{{ __("home.routes.{$place['key']}") }}</span>
                    </div>
                @endforeach
            </div>

            <figcaption class="mt-8 flex flex-wrap gap-x-8 gap-y-3 text-sm text-white/80">
                <span class="flex items-start gap-3">
                    <span class="mt-2 h-0.5 w-8 shrink-0 rounded bg-yellow" aria-hidden="true"></span>
                    <x-ui.icon name="ship" class="mt-0.5 size-4 shrink-0 text-yellow" />
                    <span><strong class="font-semibold text-white">{{ __('home.routes.sea') }}</strong> {{ __('home.routes.sea_detail') }}</span>
                </span>
                <span class="flex items-start gap-3">
                    <span class="mt-2 h-0.5 w-8 shrink-0 border-t-2 border-dotted border-mint" aria-hidden="true"></span>
                    <x-ui.icon name="plane" class="mt-0.5 size-4 shrink-0 text-mint" />
                    <span><strong class="font-semibold text-white">{{ __('home.routes.air') }}</strong> {{ __('home.routes.air_detail') }}</span>
                </span>
            </figcaption>
        </figure>
    </div>
</section>
