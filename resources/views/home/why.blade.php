@php
    $stats = $page->stats();
@endphp

<x-ui.section tone="white" data-section="why" id="why">
    <div class="grid gap-14 lg:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)] lg:gap-20">
        <div>
            <x-ui.heading :eyebrow="__('home.why.eyebrow')" :title="__('home.why.title')" />

            <h3 class="mt-10 font-display text-xl font-semibold text-navy">{{ __('home.why.what_title') }}</h3>
            <div class="mt-3 space-y-4 text-[1.05rem] leading-relaxed text-ink-soft">
                @foreach (__('home.why.what_body') as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>

            <h3 class="mt-10 font-display text-xl font-semibold text-navy">{{ __('home.why.sao_paulo_title') }}</h3>
            <ul class="mt-4 space-y-3">
                @foreach (__('home.why.sao_paulo') as $reason)
                    <li class="flex gap-3 leading-snug text-ink">
                        <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-yellow text-navy"><x-ui.icon name="check" class="size-3.5" /></span>
                        <span>{{ $reason }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        @if ($stats->isNotEmpty())
            <div>
                <p class="eyebrow">{{ __('home.why.numbers_title') }}</p>
                <div class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    @foreach ($stats as $stat)
                        @php
                            $tone = match ($loop->index) {
                                0 => 'midnight',
                                3 => 'green',
                                default => null,
                            };
                        @endphp
                        <div
                            data-reveal="scale"
                            data-reveal-delay="{{ $loop->index * 0.05 }}"
                            @if ($tone) data-tone="{{ $tone }}" @endif
                            @class([
                                'relative overflow-hidden rounded-[1.5rem] p-6 md:p-7',
                                'sm:col-span-2' => $loop->last && $stats->count() % 2 === 0,
                                'sm:col-span-2 bg-midnight text-white' => $tone === 'midnight',
                                'bg-green text-white' => $tone === 'green',
                                'bg-cream ring-1 ring-sand' => $tone === null,
                            ])
                        >
                            @if ($tone === 'midnight')
                                <x-ui.motif variant="jamdani" class="absolute inset-y-0 right-0 w-1/2 text-white/10 [mask-image:linear-gradient(to_left,black,transparent)]" />
                            @endif
                            <x-ui.stat
                                class="relative"
                                :value="$stat->value"
                                :decimals="$stat->decimals"
                                :prefix="$stat->prefix"
                                :suffix="$stat->suffix"
                                :label="$stat->label"
                                :source="$stat->source.', '.$stat->as_of"
                                :size="$tone === 'midnight' ? 'lg' : 'md'"
                            />
                        </div>
                    @endforeach
                </div>
                <p class="mt-4 text-sm text-ink-soft">{{ __('home.why.numbers_note') }}</p>
            </div>
        @endif
    </div>
</x-ui.section>
