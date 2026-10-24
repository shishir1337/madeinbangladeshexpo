@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php
    $venue = $page->edition()?->venue;
    $stampText = collect([$venue?->cityName(), __('home.where.country'), $page->dateRange()])->filter()->implode(' · ').' · ';
@endphp

{{-- Where: São Paulo and the venue. A passport stamp with the city and dates turns slowly over the skyline. --}}
@if ($venue)
    <section data-section="where" data-tone="cream" class="relative overflow-hidden bg-cream py-20 md:py-28">
        <div class="container-site grid items-center gap-14 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,0.95fr)] lg:gap-20">
            <div class="relative order-last lg:order-first" data-reveal>
                <div class="relative aspect-[4/3] overflow-hidden rounded-[2rem] shadow-float lg:aspect-[5/6]">
                    <x-ui.img key="sao-paulo-skyline" :alt="__('home.where.skyline_alt')" sizes="(min-width: 1024px) 45vw, 100vw" class="size-full object-cover" data-reveal="zoom" />
                    <div class="absolute inset-0 bg-gradient-to-t from-midnight/50 via-transparent to-transparent" aria-hidden="true"></div>
                    <p class="absolute bottom-5 left-5 woven-label woven-label--dark">{{ $venue->cityName() }}</p>
                </div>
                <p class="mt-3 text-xs text-ink-soft">{{ __('site.photo_credit', ['name' => 'Kaique Rocha / Pexels']) }}</p>

                <div class="absolute -top-10 -right-4 size-36 sm:-right-8 sm:size-44 lg:-right-12" aria-hidden="true">
                    <svg viewBox="0 0 200 200" class="size-full animate-[spin_36s_linear_infinite] drop-shadow-[0_18px_30px_rgb(7_26_51/0.3)]">
                        <defs>
                            <path id="stamp-ring" d="M100,100 m-74,0 a74,74 0 1,1 148,0 a74,74 0 1,1 -148,0" />
                        </defs>
                        <circle cx="100" cy="100" r="98" fill="#ffdf00" />
                        <circle cx="100" cy="100" r="88" fill="none" stroke="#002776" stroke-width="1.5" stroke-dasharray="4 5" />
                        <text fill="#002776" font-size="15" font-weight="700" letter-spacing="1.5"><textPath href="#stamp-ring" textLength="462" lengthAdjust="spacing">{{ mb_strtoupper($stampText) }}</textPath></text>
                    </svg>
                    <svg class="absolute top-1/2 left-1/2 w-[26%] -translate-x-1/2 -translate-y-1/2" viewBox="0 0 40 40">
                        <circle cx="15" cy="20" r="11" fill="#e8283f" />
                        <circle cx="25" cy="20" r="11" fill="#2456d6" />
                        <path d="M20 10.4a11 11 0 0 1 0 19.2 11 11 0 0 1 0-19.2Z" fill="#004f3a" />
                    </svg>
                </div>
            </div>

            <div>
                <x-ui.heading :eyebrow="__('home.where.eyebrow')" :title="__('home.where.title')" size="lg" />

                <div class="mt-10 rounded-[1.75rem] bg-white p-6 shadow-soft ring-1 ring-ink/5 md:p-8" data-reveal>
                    <div class="flex items-start gap-4">
                        <span class="grid size-12 shrink-0 place-items-center rounded-2xl bg-globe text-white"><x-ui.icon name="map-pin" class="size-6" /></span>
                        <div>
                            <p class="font-display text-2xl leading-tight font-bold text-navy">{{ $venue->name }}</p>
                            <p class="mt-1.5 text-ink-soft">{{ $venue->fullAddress() }}</p>
                        </div>
                    </div>

                    @if ($highlights = $venue->highlightList())
                        <ul class="mt-7 grid gap-3 border-t-2 border-dashed border-sand pt-6 sm:grid-cols-2">
                            @foreach ($highlights as $highlight)
                                <li class="flex gap-2.5 text-[0.95rem] leading-snug text-ink">
                                    <span class="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-green-50 text-green"><x-ui.icon name="check" class="size-3" /></span>
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
                    </div>
                </div>

                {{-- Each link is as wide as its label and the row shares out the rest, so no label breaks onto two lines. --}}
                <ul class="mt-5 grid gap-3 sm:flex sm:flex-wrap" data-reveal>
                    @foreach (['travel' => 'plane', 'hotels' => 'bed', 'city-guide' => 'compass'] as $route => $icon)
                        @if ($navigation->has($route))
                            <li class="sm:flex-auto">
                                <a href="{{ localized_route($route) }}" class="group flex h-full items-center gap-3 rounded-2xl bg-white px-4 py-3.5 font-semibold text-navy shadow-soft ring-1 ring-ink/5 transition hover:-translate-y-0.5 hover:shadow-lift">
                                    <x-ui.icon :name="$icon" class="size-5 text-green" />
                                    <span class="min-w-0 flex-1 text-[0.95rem] leading-tight whitespace-nowrap">{{ __('home.where.links.'.$route) }}</span>
                                    <x-ui.icon name="arrow-right" class="size-4 opacity-50 transition group-hover:translate-x-0.5 group-hover:opacity-100" />
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
@endif
