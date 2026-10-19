@props([
    'items',
])

@inject('formatter', 'App\Support\Localization\LocaleFormatter')

<ol {{ $attributes->class(['relative grid gap-8 md:gap-6', match (count($items)) {
    3 => 'md:grid-cols-3',
    4 => 'md:grid-cols-2 xl:grid-cols-4',
    5 => 'md:grid-cols-3 xl:grid-cols-5',
    6 => 'md:grid-cols-3 xl:grid-cols-6',
    default => 'md:grid-cols-2',
}]) }}>
    @foreach ($items as $item)
        <li class="relative flex gap-4 md:flex-col" data-reveal data-reveal-delay="{{ $loop->index * 0.06 }}">
            <div class="flex shrink-0 flex-col items-center md:flex-row">
                <span class="relative z-10 grid size-11 place-items-center rounded-full bg-green font-display text-lg font-semibold text-white ring-4 ring-cream on-dark:ring-midnight">{{ $formatter->plain($loop->iteration) }}</span>
                @unless ($loop->last)
                    <span class="mt-2 w-px flex-1 bg-sand md:mt-0 md:ml-2 md:h-px md:w-auto md:flex-1 on-dark:bg-white/15" aria-hidden="true"></span>
                @endunless
            </div>
            <div class="pb-2">
                <p class="font-display text-lg font-semibold text-navy on-dark:text-white">{{ $item['title'] }}</p>
                @if ($item['body'] ?? null)
                    <p class="mt-1.5 leading-relaxed text-ink-soft on-dark:text-white/70">{{ $item['body'] }}</p>
                @endif
                @if ($item['who'] ?? null)
                    <p class="mt-2"><x-ui.chip :tone="($item['whoTone'] ?? 'green')">{{ $item['who'] }}</x-ui.chip></p>
                @endif
            </div>
        </li>
    @endforeach
</ol>
