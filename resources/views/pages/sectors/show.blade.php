@inject('navigation', 'App\Support\Navigation\SiteNavigation')
@inject('formatter', 'App\Support\Localization\LocaleFormatter')

@php
    $breadcrumbs = [
        ['label' => __('site.home'), 'url' => localized_route('home')],
        ['label' => __('nav.items.sectors.label'), 'url' => localized_route('sectors')],
        ['label' => $sector->name],
    ];

    $sections = $body?->sections() ?? [];
    $exhibitRoute = collect(['apply', 'exhibit'])->first(fn (string $route): bool => $navigation->has($route));
    $visitRoute = collect(['visit', 'register'])->first(fn (string $route): bool => $navigation->has($route));
    $interestUrl = localized_route('home').'#updates';
@endphp

<x-layouts.site
    :title="$sector->name.' · '.__('pages/sectors.meta_title').' · '.__('site.brand')"
    :description="__('pages/sectors.show.meta_description', ['sector' => $sector->name])"
    :image="$sector->image ?? 'expo25-stand-garments'"
>
    <x-ui.page-hero :eyebrow="__('pages/sectors.eyebrow')" :title="$sector->name" :lead="$sector->summary" :breadcrumbs="$breadcrumbs">
        @if ($sector->figure_value !== null)
            <x-slot:aside>
                <div class="relative overflow-hidden rounded-[2rem] bg-midnight p-8 text-white shadow-lift md:p-10" data-tone="midnight">
                    <x-ui.motif variant="jamdani" class="absolute inset-y-0 right-0 w-2/3 text-white/10 [mask-image:linear-gradient(to_left,black,transparent)]" />
                    <span class="relative grid size-14 place-items-center rounded-2xl bg-white/10 text-yellow">
                        <x-ui.icon :name="$sector->icon" class="size-7" />
                    </span>
                    <p class="relative mt-8 font-display text-display-lg leading-none font-semibold tabular">
                        {{ $sector->figure_prefix }}{{ $formatter->number($sector->figure_value, decimals: $sector->figure_decimals) }}{{ $sector->figure_suffix }}
                    </p>
                    <p class="relative mt-3 text-lead leading-snug text-white/85">{{ $sector->figure_label }}</p>
                    @if ($sector->figure_source)
                        <p class="relative mt-2 text-sm text-white/70">{{ $sector->figure_source }}</p>
                    @endif
                </div>
            </x-slot:aside>
        @endif

        @if ($sector->hs_chapters)
            <x-slot:actions>
                <div>
                    <p class="text-xs font-semibold tracking-wide text-ink-soft uppercase">{{ __('pages/sectors.show.hs_chapters') }}</p>
                    <ul class="mt-2 flex flex-wrap gap-2">
                        @foreach ($sector->hs_chapters as $chapter)
                            <li><x-ui.chip tone="navy">{{ $chapter }}</x-ui.chip></li>
                        @endforeach
                    </ul>
                </div>
            </x-slot:actions>
        @endif
    </x-ui.page-hero>

    <x-ui.section tone="white">
        <div @class(['grid gap-12', 'lg:grid-cols-[15rem_minmax(0,1fr)] lg:gap-16' => count($sections) > 1])>
            @if (count($sections) > 1)
                <nav aria-labelledby="sector-contents" class="lg:sticky lg:top-28 lg:self-start">
                    <p id="sector-contents" class="eyebrow">{{ __('pages/sectors.show.contents') }}</p>
                    <ol class="mt-4 space-y-1 border-l border-sand">
                        @foreach ($sections as $section)
                            <li><a href="#{{ $section['id'] }}" class="-ml-px block border-l-2 border-transparent py-1.5 pl-4 text-[0.95rem] text-ink-soft transition-colors hover:border-green hover:text-navy">{{ $section['title'] }}</a></li>
                        @endforeach
                    </ol>
                </nav>
            @endif

            <div class="max-w-3xl">
                @if ($body)
                    <div class="prose-site">{!! $body->html() !!}</div>
                @else
                    <x-ui.notice>{{ __('pages/sectors.show.body_pending') }}</x-ui.notice>
                @endif

                @if ($rules !== [])
                    <div id="rules" class="mt-14 scroll-mt-28 rounded-[1.75rem] bg-cream p-7 ring-1 ring-sand md:p-9">
                        <h2 class="font-display text-display-sm font-semibold text-navy">{{ __('pages/sectors.show.rules_title') }}</h2>
                        <ul class="mt-6 space-y-3">
                            @foreach ($rules as $rule)
                                <li class="flex gap-3 leading-relaxed text-ink">
                                    <x-ui.icon name="shield-check" class="mt-1 size-5 shrink-0 text-green" />
                                    <span>{{ $rule }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <p class="mt-6 text-sm text-ink-soft">{{ __('pages/sectors.show.rules_note') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </x-ui.section>

    <x-ui.section tone="sand" id="exhibitors">
        <x-ui.heading :eyebrow="__('pages/sectors.show.exhibitors_title')" :title="$sector->name" size="sm" />

        @forelse ($exhibitors as $group)
            <p class="mt-6 text-ink-soft">{{ __('pages/sectors.show.exhibitors_lead', ['edition' => $group->first()->edition->name]) }}</p>
            <ul class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($group as $exhibitor)
                    <li class="flex items-center gap-4 rounded-2xl bg-white p-4 shadow-soft ring-1 ring-ink/5">
                        <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-green-50 font-display font-semibold text-green" aria-hidden="true">{{ mb_substr($exhibitor->name, 0, 1) }}</span>
                        @if ($exhibitor->website)
                            <a href="{{ $exhibitor->website }}" target="_blank" rel="noopener" class="link-underline font-semibold text-navy">{{ $exhibitor->name }}</a>
                        @else
                            <span class="font-semibold text-navy">{{ $exhibitor->name }}</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @empty
            <p class="mt-6 text-ink-soft">{{ __('pages/sectors.show.no_exhibitors') }}</p>
        @endforelse
    </x-ui.section>

    <x-ui.section tone="white" spacing="sm">
        <div class="grid gap-4 sm:grid-cols-2">
            <a href="{{ localized_route('sectors.show', ['sector' => $previous]) }}" class="group flex items-center gap-4 rounded-[1.5rem] bg-cream p-6 ring-1 ring-sand transition hover:-translate-y-0.5 hover:shadow-soft">
                <x-ui.icon name="arrow-left" class="size-5 shrink-0 text-ink-soft transition group-hover:-translate-x-0.5 group-hover:text-navy" />
                <span>
                    <span class="block text-xs font-semibold tracking-wide text-ink-soft uppercase">{{ __('pages/sectors.show.previous') }}</span>
                    <span class="mt-1 block font-display text-lg font-semibold text-navy">{{ $previous->name }}</span>
                </span>
            </a>
            <a href="{{ localized_route('sectors.show', ['sector' => $next]) }}" class="group flex items-center justify-end gap-4 rounded-[1.5rem] bg-cream p-6 text-right ring-1 ring-sand transition hover:-translate-y-0.5 hover:shadow-soft">
                <span>
                    <span class="block text-xs font-semibold tracking-wide text-ink-soft uppercase">{{ __('pages/sectors.show.next') }}</span>
                    <span class="mt-1 block font-display text-lg font-semibold text-navy">{{ $next->name }}</span>
                </span>
                <x-ui.icon name="arrow-right" class="size-5 shrink-0 text-ink-soft transition group-hover:translate-x-0.5 group-hover:text-navy" />
            </a>
        </div>

        <div class="mt-6 flex flex-col gap-6 overflow-hidden rounded-[2rem] bg-green p-8 text-white md:flex-row md:items-center md:justify-between md:p-10" data-tone="green">
            <div>
                <h2 class="font-display text-display-sm font-semibold text-white">{{ __('pages/sectors.show.cta_title', ['sector' => $sector->name]) }}</h2>
                <p class="mt-2 text-white/80">{{ __('pages/sectors.show.cta_lead') }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <x-ui.button :href="$exhibitRoute ? localized_route($exhibitRoute) : $interestUrl" variant="highlight" icon="arrow-right">{{ __('pages/sectors.show.cta_exhibit') }}</x-ui.button>
                <x-ui.button :href="$visitRoute ? localized_route($visitRoute) : $interestUrl" variant="on-dark">{{ __('pages/sectors.show.cta_visit') }}</x-ui.button>
            </div>
        </div>

        <p class="mt-8 text-center">
            <x-ui.link :href="localized_route('sectors')" icon="arrow-right">{{ __('pages/sectors.show.all') }}</x-ui.link>
        </p>
    </x-ui.section>
</x-layouts.site>
