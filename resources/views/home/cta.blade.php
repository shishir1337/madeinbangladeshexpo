@inject('navigation', 'App\Support\Navigation\SiteNavigation')

<section data-section="cta" data-tone="green" id="updates" class="relative isolate overflow-hidden bg-green py-16 text-white md:py-24" style="--motif-1: #0a6b4f; --motif-2: #0d5c45; --motif-3: #ffdf00">
    <x-ui.motif variant="tiles" :size="80" class="absolute inset-0 -z-10 opacity-40 [mask-image:linear-gradient(to_right,transparent,black_70%)]" />

    <div class="container-site grid grid-cols-[minmax(0,1fr)] gap-12 lg:grid-cols-2 lg:items-center lg:gap-20">
        <div>
            <h2 class="font-display text-display-lg font-semibold text-white">{{ __('home.cta.title') }}</h2>
            <p class="mt-5 max-w-xl text-lead text-white/80">{{ __('home.cta.lead') }}</p>
            <div class="mt-8 flex flex-wrap gap-3">
                @if ($navigation->has('apply') || $navigation->has('exhibit'))
                    <x-ui.button :href="localized_route($navigation->has('apply') ? 'apply' : 'exhibit')" variant="highlight" size="lg" icon="arrow-right">{{ __('home.hero.cta_exhibit') }}</x-ui.button>
                @endif
                @if ($navigation->has('register'))
                    <x-ui.button :href="localized_route('register')" variant="on-dark" size="lg">{{ __('home.hero.cta_buyer') }}</x-ui.button>
                @endif
            </div>
        </div>

        <div class="rounded-[1.75rem] bg-white p-6 text-ink shadow-lift md:p-8" data-tone="white">
            <h3 class="font-display text-2xl font-semibold text-navy">{{ __('home.cta.newsletter_title') }}</h3>
            <p class="mt-2 text-ink-soft">{{ __('home.cta.newsletter_lead') }}</p>
            <div class="mt-6">
                <livewire:newsletter-signup />
            </div>
        </div>
    </div>
</section>
