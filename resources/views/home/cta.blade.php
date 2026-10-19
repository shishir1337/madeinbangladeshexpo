@inject('navigation', 'App\Support\Navigation\SiteNavigation')

{{-- The close: Brazil yellow, the expo's mark at full size, the two ways in and the newsletter for the next dates. --}}
<section data-section="cta" data-tone="cream" id="updates" class="relative isolate overflow-hidden bg-yellow py-20 text-navy md:py-28">
    <svg class="pointer-events-none absolute top-1/2 -right-40 -z-10 w-[46rem] -translate-y-1/2 opacity-[0.16] md:-right-24 lg:opacity-100" viewBox="0 0 400 260" aria-hidden="true" focusable="false">
        <defs>
            <clipPath id="cta-sun"><circle cx="150" cy="130" r="120" /></clipPath>
        </defs>
        <circle cx="150" cy="130" r="120" fill="#e8283f" opacity=".14" />
        <circle cx="250" cy="130" r="120" fill="#2456d6" opacity=".14" />
        <circle cx="250" cy="130" r="120" fill="#004f3a" opacity=".22" clip-path="url(#cta-sun)" />
    </svg>

    <div class="container-site grid grid-cols-[minmax(0,1fr)] gap-12 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)] lg:items-center lg:gap-16">
        <div>
            <p class="eyebrow flex items-center gap-3 !text-navy" data-reveal><span class="stitch-x w-7 opacity-60" aria-hidden="true"></span>{{ __('home.cta.eyebrow') }}</p>
            <h2 class="mt-4 font-display text-display-xl font-bold tracking-[-0.035em] text-navy" data-reveal>{{ __('home.cta.title') }}</h2>
            <p class="mt-6 max-w-xl text-lead text-navy/80" data-reveal>{{ __('home.cta.lead') }}</p>
            <div class="mt-9 flex flex-wrap gap-3" data-reveal>
                @if ($navigation->has('apply') || $navigation->has('exhibit'))
                    <x-ui.button :href="localized_route($navigation->has('apply') ? 'apply' : 'exhibit')" size="lg" icon="arrow-right">{{ __('home.hero.cta_exhibit') }}</x-ui.button>
                @endif
                @if ($navigation->has('register'))
                    <x-ui.button :href="localized_route('register')" variant="secondary" size="lg">{{ __('home.hero.cta_buyer') }}</x-ui.button>
                @endif
            </div>
        </div>

        <div class="rounded-[2rem] bg-white p-7 text-ink shadow-float md:p-9" data-tone="white" data-reveal>
            <div class="flex items-center gap-3">
                <span class="grid size-11 place-items-center rounded-full bg-navy text-yellow"><x-ui.icon name="mail" class="size-5" /></span>
                <h3 class="font-display text-2xl font-bold text-navy">{{ __('home.cta.newsletter_title') }}</h3>
            </div>
            <p class="mt-3 text-ink-soft">{{ __('home.cta.newsletter_lead') }}</p>
            <div class="mt-6">
                <livewire:newsletter-signup />
            </div>
        </div>
    </div>
</section>
