@props([
    'sector',
    'href' => null,
])

@inject('formatter', 'App\Support\Localization\LocaleFormatter')

{{-- A sector with its sourced headline figure; links to the sector page when one exists. --}}
<x-ui.card :href="$href" :data-sector-card="$sector->id" {{ $attributes->class(['flex h-full flex-col']) }}>
    <div class="flex items-start justify-between gap-4">
        <span class="grid size-12 place-items-center rounded-2xl bg-green-50 text-green transition-colors duration-300 group-hover/card:bg-green group-hover/card:text-white">
            <x-ui.icon :name="$sector->icon" class="size-6" />
        </span>
        @if ($href)
            <x-ui.icon name="arrow-up-right" class="size-5 text-ink-soft transition duration-300 group-hover/card:translate-x-0.5 group-hover/card:-translate-y-0.5 group-hover/card:text-navy" />
        @endif
    </div>
    <h3 class="mt-5 font-display text-xl font-semibold text-navy">{{ $sector->name }}</h3>
    <p class="mt-2 leading-relaxed text-ink-soft">{{ $sector->summary }}</p>
    @if ($sector->figure_value !== null)
        <div class="mt-auto border-t border-sand pt-5">
            <p class="font-display text-2xl font-semibold text-green tabular">
                {{ $sector->figure_prefix }}{{ $formatter->number($sector->figure_value, decimals: $sector->figure_decimals) }}{{ $sector->figure_suffix }}
            </p>
            <p class="mt-1 text-sm leading-snug text-ink">{{ $sector->figure_label }}</p>
            @if ($sector->figure_source)
                <p class="mt-1 text-xs text-ink-soft">{{ $formatter->digits($sector->figure_source) }}</p>
            @endif
        </div>
    @endif
</x-ui.card>
