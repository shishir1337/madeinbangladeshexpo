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
                    <x-ui.sector-card :sector="$sector" :href="$sectorPages ? localized_route('sectors.show', ['sector' => $sector]) : null" />
                </li>
            @endforeach
        </ul>
    </x-ui.section>
@endif
