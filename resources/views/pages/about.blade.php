@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php
    $breadcrumbs = [
        ['label' => __('site.home'), 'url' => localized_route('home')],
        ['label' => __('nav.items.about.label')],
    ];

    $formats = [
        'exhibition' => 'store',
        'b2b' => 'puzzle',
        'seminars' => 'mic',
        'networking' => 'users',
    ];

    $stats = $page->stats();
    $comparison = $page->comparison();
    $previous = $page->previous();
    $edition = $page->edition();
@endphp

<x-layouts.site :title="__('pages/about.meta_title').' · '.__('site.brand')" :description="__('pages/about.meta_description')" image="expo25-welcome">
    <x-ui.page-hero
        :eyebrow="__('pages/about.eyebrow')"
        :title="__('pages/about.title')"
        :lead="__('pages/about.lead')"
        image="expo25-welcome"
        :image-alt="__('pages/about.image_alt')"
        :breadcrumbs="$breadcrumbs"
    >
        @if ($facts = $page->facts())
            <x-slot:facts>
                <x-ui.facts :items="$facts" />
            </x-slot:facts>
        @endif
    </x-ui.page-hero>

    <x-ui.section tone="white" id="format">
        <x-ui.heading :eyebrow="__('pages/about.format.eyebrow')" :title="__('pages/about.format.title')" :lead="__('pages/about.format.lead')" />

        <div class="mt-12 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($formats as $key => $icon)
                <article class="rounded-[1.75rem] bg-cream p-7 ring-1 ring-sand" data-reveal data-reveal-delay="{{ $loop->index * 0.06 }}">
                    <span class="grid size-12 place-items-center rounded-2xl bg-green text-white">
                        <x-ui.icon :name="$icon" class="size-6" />
                    </span>
                    <h3 class="mt-6 font-display text-xl font-semibold text-navy">{{ __("pages/about.format.items.{$key}.title") }}</h3>
                    <p class="mt-2 leading-relaxed text-ink-soft">{{ __("pages/about.format.items.{$key}.body") }}</p>
                </article>
            @endforeach
        </div>
    </x-ui.section>

    @include('home.paths')

    <x-ui.section tone="white" id="sao-paulo">
        <div class="grid items-center gap-12 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] lg:gap-16">
            <div>
                <x-ui.heading :eyebrow="__('pages/about.sao_paulo.eyebrow')" :title="__('pages/about.sao_paulo.title')" :lead="__('pages/about.sao_paulo.lead')" />

                <ul class="mt-8 space-y-3">
                    @foreach (__('home.why.sao_paulo') as $reason)
                        <li class="flex gap-3 leading-snug text-ink">
                            <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-yellow text-navy"><x-ui.icon name="check" class="size-3.5" /></span>
                            <span>{{ $reason }}</span>
                        </li>
                    @endforeach
                </ul>

                @if ($stats->isNotEmpty())
                    <p class="eyebrow mt-10">{{ __('pages/about.sao_paulo.figures') }}</p>
                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        @foreach ($stats as $stat)
                            <div class="rounded-[1.5rem] bg-cream p-6 ring-1 ring-sand" data-reveal="scale" data-reveal-delay="{{ $loop->index * 0.05 }}">
                                <x-ui.stat
                                    :value="$stat->value"
                                    :decimals="$stat->decimals"
                                    :prefix="$stat->prefix"
                                    :suffix="$stat->suffix"
                                    :label="$stat->label"
                                    :source="$stat->source.', '.$stat->as_of"
                                    size="md"
                                />
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div>
                <div class="aspect-[4/5] overflow-hidden rounded-[2rem] shadow-lift">
                    <x-ui.img key="sao-paulo-skyline" :alt="__('pages/about.sao_paulo.image_alt')" sizes="(min-width: 1024px) 45vw, 100vw" class="size-full object-cover" />
                </div>
                <p class="mt-3 text-xs text-ink-soft">{{ __('site.photo_credit', ['name' => 'Kaique Rocha / Pexels']) }}</p>
            </div>
        </div>
    </x-ui.section>

    @if ($comparison !== [])
        <x-ui.section tone="sand" id="editions">
            <x-ui.heading :eyebrow="__('pages/about.comparison.eyebrow')" :title="__('pages/about.comparison.title')" :lead="__('pages/about.comparison.lead')" />

            <div class="mt-12 grid gap-8 lg:grid-cols-[minmax(0,1.5fr)_minmax(0,1fr)] lg:gap-12">
                <div class="overflow-hidden rounded-[1.75rem] bg-white shadow-soft ring-1 ring-ink/5">
                    <table class="w-full text-left">
                        <caption class="sr-only">{{ __('pages/about.comparison.caption') }}</caption>
                        <thead>
                            <tr class="border-b border-sand">
                                <th scope="col" class="hidden p-5 text-xs font-semibold tracking-wide text-ink-soft uppercase sm:table-cell md:p-6">{{ __('pages/about.comparison.aspect') }}</th>
                                <th scope="col" class="p-5 align-bottom md:p-6">
                                    <span class="block text-xs font-semibold tracking-wide text-ink-soft uppercase">{{ $page->ordinal($previous) }}</span>
                                    <span class="mt-1 block font-display text-lg font-semibold text-navy">{{ $previous->name }}</span>
                                </th>
                                <th scope="col" class="bg-green-50 p-5 align-bottom md:p-6">
                                    <span class="block text-xs font-semibold tracking-wide text-green uppercase">{{ $page->ordinal($edition) }}</span>
                                    <span class="mt-1 block font-display text-lg font-semibold text-navy">{{ $edition->name }}</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($comparison as $row)
                                <tr class="border-b border-sand/70 last:border-0">
                                    <th scope="row" class="hidden p-5 text-sm font-semibold text-ink-soft sm:table-cell md:p-6">{{ $row['label'] }}</th>
                                    <td class="p-5 align-top text-ink md:p-6">
                                        <span class="block text-xs font-semibold text-ink-soft sm:hidden">{{ $row['label'] }}</span>
                                        {{ $row['previous'] }}
                                    </td>
                                    <td class="bg-green-50/60 p-5 align-top font-semibold text-navy md:p-6">
                                        <span class="block text-xs font-semibold text-ink-soft sm:hidden">{{ $row['label'] }}</span>
                                        {{ $row['current'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="rounded-[1.75rem] bg-midnight p-7 text-white md:p-8" data-tone="midnight">
                    <p class="eyebrow !text-mint">{{ __('pages/about.comparison.new_title') }}</p>
                    <ul class="mt-6 space-y-4">
                        @foreach (__('pages/about.comparison.new') as $item)
                            <li class="flex gap-3 leading-snug">
                                <x-ui.icon name="sparkles" class="mt-0.5 size-5 shrink-0 text-yellow" />
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                    @if ($navigation->has('archive'))
                        <x-ui.link :href="localized_route('archive')" class="mt-8">{{ __('home.highlights.archive') }}</x-ui.link>
                    @endif
                </div>
            </div>
        </x-ui.section>
    @endif

    <x-ui.section tone="white" spacing="sm">
        <div class="grid items-center gap-8 rounded-[2rem] bg-cream p-7 ring-1 ring-sand md:grid-cols-[auto_minmax(0,1fr)_auto] md:p-10">
            <div class="size-20 overflow-hidden rounded-2xl bg-white p-2 ring-1 ring-ink/5">
                <x-ui.img key="bbcci-mark" alt="BBCCI" sizes="80px" class="size-full object-contain" />
            </div>
            <div>
                <p class="eyebrow">{{ __('pages/about.organiser.eyebrow') }}</p>
                <h2 class="mt-2 font-display text-display-sm font-semibold text-navy">{{ __('pages/about.organiser.title') }}</h2>
                <p class="mt-3 max-w-2xl leading-relaxed text-ink-soft">{{ __('pages/about.organiser.lead') }}</p>
            </div>
            <div class="flex flex-wrap gap-3 md:flex-col">
                <x-ui.button :href="localized_route('organiser')" icon="arrow-right">{{ __('pages/about.organiser.cta') }}</x-ui.button>
                <x-ui.button :href="localized_route('committee')" variant="secondary">{{ __('pages/about.organiser.committee') }}</x-ui.button>
            </div>
        </div>
    </x-ui.section>
</x-layouts.site>
