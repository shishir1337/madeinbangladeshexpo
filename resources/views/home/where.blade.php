@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php($venue = $page->edition()?->venue)

@if ($venue)
    <section data-section="where" data-tone="white" class="relative bg-white py-16 md:py-24">
        <div class="container-site grid items-center gap-12 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)] lg:gap-16">
            <div class="relative order-last lg:order-first">
                <div class="aspect-[4/3] overflow-hidden rounded-[2rem] shadow-lift">
                    <x-ui.img key="sao-paulo-skyline" :alt="__('home.where.skyline_alt')" sizes="(min-width: 1024px) 50vw, 100vw" class="size-full object-cover" />
                </div>
                <p class="mt-3 text-xs text-ink-soft">Photo: Kaique Rocha / Pexels</p>
                <div class="absolute -top-5 -right-3 hidden rounded-2xl bg-yellow px-5 py-4 text-navy shadow-lift sm:block lg:-right-6">
                    <p class="text-xs font-semibold tracking-wide uppercase">{{ __('home.hero.facts.dates') }}</p>
                    <p class="mt-1 font-display text-lg leading-tight font-semibold">{{ $page->dateRange() }}</p>
                </div>
            </div>

            <div>
                <x-ui.heading :eyebrow="__('home.where.eyebrow')" :title="__('home.where.title')" />

                <div class="mt-8 rounded-[1.75rem] bg-cream p-6 ring-1 ring-sand md:p-8">
                    <p class="font-display text-2xl font-semibold text-navy">{{ $venue->name }}</p>
                    <p class="mt-2 flex gap-2 text-ink-soft">
                        <x-ui.icon name="map-pin" class="mt-1 size-4 text-green" />
                        <span>{{ $venue->fullAddress() }}</span>
                    </p>

                    @if ($highlights = $venue->highlightList())
                        <ul class="mt-6 grid gap-3 sm:grid-cols-2">
                            @foreach ($highlights as $highlight)
                                <li class="flex gap-2.5 text-[0.95rem] leading-snug text-ink">
                                    <x-ui.icon name="check" class="mt-0.5 size-4 text-green" />
                                    <span>{{ $highlight }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="mt-8 flex flex-wrap gap-3">
                        <x-ui.button :href="$venue->directionsUrl()" icon-start="navigation" target="_blank" rel="noopener">{{ __('home.where.directions') }}</x-ui.button>
                        @if ($navigation->has('venue'))
                            <x-ui.button :href="localized_route('venue')" variant="secondary">{{ __('home.where.venue_page') }}</x-ui.button>
                        @endif
                        @if ($navigation->has('travel'))
                            <x-ui.button :href="localized_route('travel')" variant="ghost" icon="arrow-right">{{ __('home.where.travel_page') }}</x-ui.button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
