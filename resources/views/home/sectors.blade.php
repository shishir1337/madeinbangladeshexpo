@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php
    $sectors = $page->sectors();
    $sectorPages = Route::has(app()->getLocale().'.sectors.show');
@endphp

@if ($sectors->isNotEmpty())
    <x-ui.section tone="cream" data-section="sectors" id="sectors">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-ui.heading :eyebrow="__('home.sectors.eyebrow')" :title="__('home.sectors.title')" :lead="__('home.sectors.lead')" />
            @if ($navigation->has('sectors'))
                <x-ui.button :href="localized_route('sectors')" variant="secondary" icon="arrow-right">{{ __('home.sectors.all') }}</x-ui.button>
            @endif
        </div>

        <ul class="swipe-row mt-12 gap-4 sm:grid sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($sectors as $sector)
                <li data-reveal data-reveal-delay="{{ ($loop->index % 3) * 0.06 }}">
                    <x-ui.card
                        :href="$sectorPages ? localized_route('sectors.show', ['sector' => $sector->localizedSlug(app()->getLocale())]) : null"
                        class="flex h-full flex-col"
                    >
                        <div class="flex items-start justify-between gap-4">
                            <span class="grid size-12 place-items-center rounded-2xl bg-green-50 text-green transition-colors duration-300 group-hover/card:bg-green group-hover/card:text-white">
                                <x-ui.icon :name="$sector->icon" class="size-6" />
                            </span>
                            @if ($sectorPages)
                                <x-ui.icon name="arrow-up-right" class="size-5 text-ink-soft transition duration-300 group-hover/card:translate-x-0.5 group-hover/card:-translate-y-0.5 group-hover/card:text-navy" />
                            @endif
                        </div>
                        <h3 class="mt-5 font-display text-xl font-semibold text-navy">{{ $sector->name }}</h3>
                        <p class="mt-2 leading-relaxed text-ink-soft">{{ $sector->summary }}</p>
                        @if ($sector->figure_value !== null)
                            <div class="mt-auto border-t border-sand pt-5">
                                <p class="font-display text-2xl font-semibold text-green tabular">
                                    {{ $sector->figure_prefix }}{{ $page->formatter()->number($sector->figure_value, decimals: $sector->figure_decimals) }}{{ $sector->figure_suffix }}
                                </p>
                                <p class="mt-1 text-sm leading-snug text-ink">{{ $sector->figure_label }}</p>
                                @if ($sector->figure_source)
                                    <p class="mt-1 text-xs text-ink-soft">{{ $sector->figure_source }}</p>
                                @endif
                            </div>
                        @endif
                    </x-ui.card>
                </li>
            @endforeach
        </ul>
    </x-ui.section>
@endif
