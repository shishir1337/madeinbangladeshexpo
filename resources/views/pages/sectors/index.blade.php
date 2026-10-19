@php
    $breadcrumbs = [
        ['label' => __('site.home'), 'url' => localized_route('home')],
        ['label' => __('nav.items.sectors.label')],
    ];
@endphp

<x-layouts.site :title="__('pages/sectors.meta_title').' · '.__('site.brand')" :description="__('pages/sectors.meta_description')">
    <x-ui.page-hero
        variant="dark"
        :eyebrow="__('pages/sectors.eyebrow')"
        :title="__('pages/sectors.title')"
        :lead="__('pages/sectors.lead')"
        :breadcrumbs="$breadcrumbs"
    />

    <x-ui.section tone="cream">
        <ul class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($sectors as $sector)
                <li data-reveal data-reveal-delay="{{ ($loop->index % 3) * 0.06 }}">
                    <x-ui.sector-card :sector="$sector" :href="localized_route('sectors.show', ['sector' => $sector])" />
                </li>
            @endforeach
        </ul>

        <p class="mt-8 flex max-w-3xl gap-2.5 text-sm leading-relaxed text-ink-soft">
            <x-ui.icon name="info" class="mt-0.5 size-4 shrink-0 text-green" />
            <span>{{ __('pages/sectors.years_note') }}</span>
        </p>
    </x-ui.section>
</x-layouts.site>
