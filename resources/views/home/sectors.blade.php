@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php
    $sectors = $page->sectors();
    $sectorPages = Route::has(app()->getLocale().'.sectors.show');
    $formatter = $page->formatter();

    // Each sector is drawn as its own material: denim for garments, terry for home textiles, jute weave, leather...
    $materials = [
        'garments' => 'twill',
        'textiles' => 'terry',
        'pharmaceuticals' => 'capsule',
        'leather-footwear' => 'leather',
        'jute' => 'jute',
        'agro-food' => 'grain',
        'handicrafts' => 'kantha',
        'plastics-toys' => 'toys',
        'ict' => 'circuit',
    ];
@endphp

@if ($sectors->isNotEmpty())
    <x-ui.section tone="cream" data-section="sectors" id="sectors" spacing="lg">
        <div class="flex flex-wrap items-end justify-between gap-8">
            <x-ui.heading :eyebrow="__('home.sectors.eyebrow')" :title="__('home.sectors.title')" :lead="__('home.sectors.lead')" size="lg" />
            @if ($navigation->has('sectors'))
                <x-ui.button :href="localized_route('sectors')" variant="secondary" icon="arrow-right" data-reveal>{{ __('home.sectors.all') }}</x-ui.button>
            @endif
        </div>

        <ul class="swipe-row mt-14 sm:grid sm:auto-rows-[15rem] sm:grid-cols-2 sm:gap-4 lg:grid-cols-4 lg:auto-rows-[16.5rem]" tabindex="0" aria-label="{{ __('home.sectors.title') }}">
            @foreach ($sectors as $sector)
                @php
                    $featured = $loop->first;
                    $href = $sectorPages ? localized_route('sectors.show', ['sector' => $sector]) : null;
                @endphp
                <li data-reveal @class(['min-h-[17rem] sm:min-h-0', 'sm:col-span-2 sm:row-span-2' => $featured])>
                    <article data-sector-card="{{ $sector->id }}" data-tone="midnight" class="group relative isolate flex h-full flex-col overflow-hidden rounded-[1.5rem] p-6 text-white shadow-soft transition duration-500 hover:shadow-float md:p-7">
                        <div class="swatch swatch--{{ $materials[$sector->slug] ?? 'twill' }} absolute inset-0 -z-20 transition-transform duration-[1.2s] ease-[var(--ease-out-quint)] group-hover:scale-[1.08]" aria-hidden="true"></div>
                        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-black/70 via-black/20 to-transparent" aria-hidden="true"></div>

                        <div class="flex items-start justify-between gap-4">
                            <span class="grid size-12 place-items-center rounded-2xl bg-white/15 ring-1 ring-white/25 backdrop-blur-sm">
                                <x-ui.icon :name="$sector->icon" class="size-6" />
                            </span>
                            @if ($href)
                                <span class="grid size-10 place-items-center rounded-full bg-white text-navy opacity-0 transition duration-500 group-hover:rotate-0 group-hover:opacity-100 group-focus-within:opacity-100 -rotate-45" aria-hidden="true">
                                    <x-ui.icon name="arrow-up-right" class="size-5" />
                                </span>
                            @endif
                        </div>

                        <div class="mt-auto">
                            <h3 @class([
                                'font-display leading-[1.02] font-bold tracking-[-0.02em] text-white',
                                'text-[clamp(2rem,1.4rem+2vw,3.25rem)]' => $featured,
                                'text-2xl' => ! $featured,
                            ])>
                                @if ($href)
                                    <a href="{{ $href }}" class="after:absolute after:inset-0 after:rounded-[1.5rem] focus-visible:outline-none">{{ $sector->name }}</a>
                                @else
                                    {{ $sector->name }}
                                @endif
                            </h3>
                            @if ($featured)
                                <p class="mt-3 max-w-md leading-relaxed text-white/85">{{ $sector->summary }}</p>
                            @endif

                            @if ($sector->figure_value !== null)
                                <div @class(['mt-4 border-t border-white/20 pt-4', 'sm:flex sm:items-end sm:gap-4' => $featured])>
                                    <p class="font-display text-[1.7rem] leading-none font-bold whitespace-nowrap text-yellow tabular">{{ $sector->figure_prefix }}{{ $formatter->number($sector->figure_value, decimals: $sector->figure_decimals) }}{{ $sector->figure_suffix }}</p>
                                    <p @class(['min-w-0 text-xs leading-snug text-white/75', 'mt-2' => ! $featured, 'mt-2 sm:mt-0' => $featured])>
                                        <span @class(['block', 'line-clamp-2' => ! $featured])>{{ $sector->figure_label }}</span>
                                        @if ($sector->figure_source)
                                            <span class="block text-white/55">{{ $formatter->digits($sector->figure_source) }}</span>
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                    </article>
                </li>
            @endforeach
        </ul>
    </x-ui.section>
@endif
