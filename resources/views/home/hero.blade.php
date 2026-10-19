@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php
    $edition = $page->edition();
    $editionLabel = $edition ? (__('home.hero.edition')[$edition->number] ?? __('home.hero.edition.n', ['number' => $page->formatter()->plain($edition->number)])) : null;
    $exhibitRoute = $navigation->has('apply') ? 'apply' : ($navigation->has('exhibit') ? 'exhibit' : null);
    $buyerRoute = $navigation->has('register') ? 'register' : ($navigation->has('visit') ? 'visit' : null);
    $sectorCount = $page->sectors()->count();

    $facts = array_values(array_filter([
        ['icon' => 'calendar', 'label' => __('home.hero.facts.dates'), 'value' => $page->dateRange() ?? __('site.dates_to_be_announced')],
        $page->venueLine() ? ['icon' => 'map-pin', 'label' => __('home.hero.facts.venue'), 'value' => $page->venueLine()] : null,
        ['icon' => 'ticket', 'label' => __('home.hero.facts.buyers'), 'value' => __('home.hero.facts.buyers_value')],
        $sectorCount > 0 ? ['icon' => 'layers', 'label' => __('home.hero.facts.sectors'), 'value' => __('home.hero.facts.sectors_value', ['count' => $page->formatter()->plain($sectorCount)])] : null,
    ]));
@endphp

<section data-hero data-tone="midnight" class="relative isolate overflow-hidden bg-midnight text-white" style="--motif-1: #0c2444; --motif-2: #10305a; --motif-3: #1b5a55">
    <x-ui.motif variant="tiles" :size="96" class="absolute inset-y-0 right-0 -z-20 w-full opacity-50 lg:w-3/5 [mask-image:linear-gradient(to_left,black_30%,transparent)]" />
    <div class="absolute -top-40 -left-40 -z-10 size-[36rem] rounded-full bg-green/45 blur-3xl" aria-hidden="true"></div>
    <div class="absolute -right-24 bottom-0 -z-10 size-80 rounded-full bg-navy/50 blur-3xl" aria-hidden="true"></div>

    <div class="container-site grid items-center gap-12 pt-10 pb-12 md:pt-14 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,0.95fr)] lg:gap-14 lg:pt-16 lg:pb-16">
        <div>
            @if ($editionLabel)
                <p class="eyebrow !text-mint">{{ $editionLabel }} · {{ $page->edition()->venue?->city }}</p>
            @endif

            <h1 class="mt-4 font-display text-display-2xl font-semibold text-balance text-white">{{ $page->title() }}</h1>

            <p class="mt-6 max-w-xl text-lead text-white/80">
                {{ $edition ? __('home.hero.lead', ['days' => $page->formatter()->plain($page->durationInDays())]) : __('home.hero.lead_no_edition') }}
            </p>

            <div class="mt-8 flex flex-wrap gap-3">
                @if ($exhibitRoute)
                    <x-ui.button :href="localized_route($exhibitRoute)" variant="highlight" size="lg" icon="arrow-right">{{ __('home.hero.cta_exhibit') }}</x-ui.button>
                @endif
                @if ($buyerRoute)
                    <x-ui.button :href="localized_route($buyerRoute)" variant="on-dark" size="lg">{{ __('home.hero.cta_buyer') }}</x-ui.button>
                @endif
                @if (! $exhibitRoute && ! $buyerRoute)
                    <x-ui.button href="#updates" variant="highlight" size="lg" icon="arrow-down">{{ __('home.hero.cta_updates') }}</x-ui.button>
                @endif
            </div>

            <div class="mt-10 flex items-center gap-3 text-sm text-white/70">
                <x-ui.img key="bbcci-mark" alt="" sizes="40px" class="size-10 rounded-lg" />
                <p class="max-w-xs leading-snug">{{ __('site.organised_by', ['organiser' => $settings->organiser_name]) }}</p>
            </div>
        </div>

        <div class="relative">
            <div class="grid h-[clamp(20rem,52vw,34rem)] grid-cols-6 grid-rows-6 gap-3 sm:gap-4">
                <div class="relative col-span-6 row-span-6 overflow-hidden rounded-[2rem] shadow-lift ring-1 ring-white/10 sm:col-span-4">
                    <x-ui.img key="expo25-stand-garments" :alt="__('home.hero.photo_main')" eager sizes="(min-width: 1024px) 32vw, (min-width: 640px) 66vw, 100vw" class="size-full object-cover" />
                    <div class="absolute inset-0 bg-gradient-to-t from-midnight/70 via-transparent to-transparent" aria-hidden="true"></div>
                    @if ($video = $page->videos()->firstWhere('youtube_id', 'AhCawT3n2Uo') ?? $page->videos()->first())
                        <div class="absolute inset-x-4 bottom-4 sm:inset-x-5 sm:bottom-5">
                            <x-ui.video-dialog :youtube-id="$video->youtube_id" :title="$video->title">
                                {{ __('home.hero.watch') }}
                            </x-ui.video-dialog>
                        </div>
                    @endif
                </div>
                <div class="relative col-span-2 col-start-5 row-span-3 hidden overflow-hidden rounded-[1.5rem] shadow-lift ring-1 ring-white/10 sm:block">
                    <x-ui.img key="expo25-delegation" :alt="__('home.hero.photo_delegation')" sizes="(min-width: 1024px) 15vw, 30vw" class="size-full object-cover object-[center_40%]" />
                </div>
                <div class="relative col-span-2 col-start-5 row-span-3 row-start-4 hidden overflow-hidden rounded-[1.5rem] shadow-lift ring-1 ring-white/10 sm:block">
                    <x-ui.img key="expo25-speaker-regina-nunes" :alt="__('home.hero.photo_speaker')" sizes="(min-width: 1024px) 15vw, 30vw" class="size-full object-cover object-[60%_center]" />
                </div>
            </div>
            <p class="absolute -top-3 left-6 inline-flex -rotate-3 items-center gap-2 rounded-full bg-yellow px-4 py-2 text-sm font-semibold text-navy shadow-lift sm:-left-4 sm:top-8">
                <x-ui.icon name="ticket" class="size-4" />
                {{ __('home.hero.free_badge') }}
            </p>
        </div>
    </div>

    <div class="container-site pb-14 lg:pb-20">
        <x-ui.facts :items="$facts" />
    </div>
</section>
