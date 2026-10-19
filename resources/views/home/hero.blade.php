@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php
    $edition = $page->edition();
    $editionLabel = $edition ? (__('home.hero.edition')[$edition->number] ?? __('home.hero.edition.n', ['number' => $page->formatter()->plain($edition->number)])) : null;
    $exhibitRoute = $navigation->has('apply') ? 'apply' : ($navigation->has('exhibit') ? 'exhibit' : null);
    $buyerRoute = $navigation->has('register') ? 'register' : null;
    $title = $page->titleParts();
    $words = preg_split('/\s+/u', $title['series'], -1, PREG_SPLIT_NO_EMPTY);
@endphp

{{--
    The hero is the expo's mark at full size: Bangladesh's red sun and Brazil's blue globe, each framing a photo,
    slide together; where they overlap is green, the colour both flags share, with Brazil's yellow diamond at the
    centre. The series name stays the same every year; the edition (its year) is the yellow stamp.
--}}
<section data-hero data-tone="midnight" data-pause-offscreen class="relative isolate -mt-16 overflow-hidden bg-midnight text-white lg:-mt-[4.5rem]">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(55%_65%_at_82%_35%,rgb(36_86_214/0.32),transparent_70%),radial-gradient(45%_60%_at_8%_95%,rgb(0_79_58/0.6),transparent_72%),linear-gradient(180deg,#06152b_0%,#071a33_60%,#0a2240_100%)]" aria-hidden="true"></div>
    <img src="{{ asset('img/world-dots.svg') }}" alt="" width="1000" height="380" decoding="async" class="pointer-events-none absolute top-24 right-[-18%] -z-10 w-[120%] max-w-none opacity-[0.09] select-none lg:right-[-8%] lg:w-[85%]" aria-hidden="true">

    <div class="container-site grid min-h-[max(40rem,calc(100svh-2.75rem))] items-center gap-14 pt-28 pb-20 lg:grid-cols-12 lg:gap-6 lg:pt-32 lg:pb-20">
        <div class="scroll-fade lg:col-span-7" data-enter>
            <p class="woven-label woven-label--dark" style="--i: 0">
                <span class="flex gap-1" aria-hidden="true"><span class="size-2 rounded-full bg-sun"></span><span class="size-2 rounded-full bg-globe"></span></span>
                @if ($editionLabel)
                    {{ collect([$editionLabel, $edition->venue?->cityName()])->filter()->implode(' · ') }}
                @else
                    {{ __('site.dates_to_be_announced') }}
                @endif
            </p>

            <h1 class="words-rise mt-7 font-display text-display-3xl font-bold tracking-[-0.035em] text-balance text-white">
                @foreach ($words as $word)
                    <span class="word"><span style="--w: {{ $loop->index }}">{{ $word }}</span></span>
                @endforeach
                @if ($title['edition'] !== '')
                    <span class="word align-[0.12em]"><span style="--w: {{ count($words) }}" class="ml-[0.08em] inline-block -rotate-3 rounded-[0.18em] bg-yellow px-[0.16em] pt-[0.06em] text-[0.62em] leading-none tracking-[-0.02em] text-navy shadow-[0_0.08em_0_rgb(0_0_0/0.25)]">{{ $title['edition'] }}</span></span>
                @endif
            </h1>

            <p class="mt-7 max-w-xl text-lead text-white/80" style="--i: 3">
                {{ $edition ? __('home.hero.lead', ['days' => $page->formatter()->plain($page->durationInDays())]) : __('home.hero.lead_no_edition') }}
            </p>

            <div class="mt-9 flex flex-wrap gap-3" style="--i: 4">
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

            <div class="mt-10 flex flex-wrap items-center gap-x-7 gap-y-5" style="--i: 5">
                @if ($video = $page->featuredVideo())
                    <x-ui.video-dialog :youtube-id="$video->youtube_id" :title="$video->title">{{ __('home.hero.watch') }}</x-ui.video-dialog>
                @endif
                <div class="flex items-center gap-3 text-sm text-white/70">
                    <x-ui.img key="bbcci-mark" alt="" sizes="40px" class="size-10 rounded-lg bg-white/90 p-0.5" />
                    <p class="max-w-[15rem] leading-snug">{{ __('site.organised_by', ['organiser' => $settings->organiser_name]) }}</p>
                </div>
            </div>
        </div>

        <div class="scroll-drift lg:col-span-5">
            <div class="hero-discs relative mx-auto aspect-[1.62/1] w-full max-w-[36rem] lg:-mr-6 xl:-mr-12">
                <div class="hero-disc hero-disc--sun absolute top-0 left-0 aspect-square w-[61.7%] rounded-full border-[clamp(5px,0.9vw,12px)] border-sun bg-sun shadow-float">
                    <div class="size-full overflow-hidden rounded-full">
                        <x-ui.img key="expo25-stand-garments" :alt="__('home.hero.photo_main')" eager sizes="(min-width: 1024px) 22rem, 62vw" class="size-full object-cover object-[45%_center]" />
                    </div>
                </div>
                <div class="hero-disc hero-disc--globe absolute top-0 right-0 aspect-square w-[61.7%] rounded-full border-[clamp(5px,0.9vw,12px)] border-globe bg-globe shadow-float">
                    <div class="size-full overflow-hidden rounded-full">
                        <x-ui.img key="sao-paulo-skyline" :alt="__('home.where.skyline_alt')" sizes="(min-width: 1024px) 22rem, 62vw" class="size-full object-cover" />
                    </div>
                </div>
                {{-- The overlap: the globe's disc clipped to the sun's circle (the sun's centre sits at -12% of the globe's box). --}}
                <div class="hero-lens pointer-events-none absolute top-0 right-0 aspect-square w-[61.7%] rounded-full bg-green/90 [clip-path:circle(50%_at_-12%_50%)]" aria-hidden="true"></div>
                <svg class="hero-diamond pointer-events-none absolute top-1/2 left-1/2 w-[13%] -translate-x-1/2 -translate-y-1/2 drop-shadow-[0_6px_14px_rgb(0_0_0/0.35)]" viewBox="0 0 40 40" aria-hidden="true" focusable="false">
                    <path d="M20 2 38 20 20 38 2 20Z" fill="#ffdf00" />
                </svg>

                <p class="hero-tag absolute -bottom-3 left-[4%] woven-label -rotate-[5deg]" aria-hidden="true">{{ __('home.hero.makers') }}</p>
                <p class="hero-tag absolute -top-4 right-[3%] woven-label rotate-[4deg]" style="--label-fg: var(--color-globe)" aria-hidden="true">{{ __('home.hero.buyers') }}</p>
                <p class="hero-tag absolute -top-5 left-[2%] inline-flex -rotate-[4deg] items-center gap-2 rounded-full bg-yellow px-4 py-2 text-sm font-semibold text-navy shadow-lift">
                    <x-ui.icon name="ticket" class="size-4" />
                    {{ __('home.hero.free_badge') }}
                </p>
            </div>
        </div>
    </div>

    @include('home.marquee')
</section>
