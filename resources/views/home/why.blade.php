@php
    $stats = $page->stats();
    $formatter = $page->formatter();
@endphp

{{-- The case for the expo: the story on the left stays in view while the sourced figures scroll past as a ledger. --}}
<x-ui.section tone="white" data-section="why" id="why" spacing="lg">
    <div class="grid gap-14 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)] lg:gap-20">
        <div class="lg:sticky lg:top-28 lg:self-start">
            <x-ui.heading :eyebrow="__('home.why.eyebrow')" :title="__('home.why.title')" size="lg" />

            <div class="mt-8 space-y-4 text-[1.05rem] leading-relaxed text-ink-soft" data-reveal>
                @foreach (__('home.why.what_body') as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>

            <div class="mt-10 rounded-[1.5rem] bg-cream p-6 ring-1 ring-sand md:p-7" data-reveal>
                <h3 class="flex items-center gap-3 font-display text-xl font-bold text-navy">
                    <span class="grid size-9 place-items-center rounded-full bg-globe text-white"><x-ui.icon name="map-pin" class="size-4" /></span>
                    {{ __('home.why.sao_paulo_title') }}
                </h3>
                <ul class="mt-5 space-y-3.5">
                    @foreach (__('home.why.sao_paulo') as $reason)
                        <li class="flex gap-3 leading-snug text-ink">
                            <span class="mt-0.5 grid size-6 shrink-0 place-items-center rounded-full bg-yellow text-navy"><x-ui.icon name="check" class="size-3.5" /></span>
                            <span>{{ $reason }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        @if ($stats->isNotEmpty())
            <div>
                <p class="eyebrow flex items-center gap-3"><span class="stitch-x w-7 opacity-60" aria-hidden="true"></span>{{ __('home.why.numbers_title') }}</p>
                <ol class="mt-6">
                    @foreach ($stats as $stat)
                        <li class="group relative py-7 md:py-9" data-reveal>
                            <span class="stitch-x absolute inset-x-0 top-0 text-sand-2" aria-hidden="true"></span>
                            <div class="grid gap-x-8 gap-y-3 sm:grid-cols-[minmax(0,1.1fr)_minmax(0,1fr)] sm:items-end">
                                <p class="font-display text-[clamp(3.4rem,2rem+5vw,6.25rem)] leading-[0.85] font-bold tracking-[-0.04em] text-navy tabular transition-colors duration-500 group-hover:text-green">
                                    @if ($stat->prefix)<span class="mr-1 align-[0.55em] text-[0.32em] font-semibold tracking-normal">{{ $stat->prefix }}</span>@endif<span data-count-to="{{ $stat->value }}" data-count-decimals="{{ $stat->decimals }}">{{ $formatter->number($stat->value, decimals: $stat->decimals) }}</span>@if ($stat->suffix)<span class="ml-1 text-[0.4em] font-semibold tracking-normal">{{ $stat->suffix }}</span>@endif
                                </p>
                                <div class="sm:pb-1">
                                    <p class="text-[1.05rem] leading-snug font-medium text-ink">{{ $stat->label }}</p>
                                    <p class="mt-1.5 text-xs leading-snug text-ink-soft">{{ $formatter->digits($stat->source.', '.$stat->as_of) }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
                <p class="relative pt-6 text-sm text-ink-soft"><span class="stitch-x absolute inset-x-0 top-0 text-sand-2" aria-hidden="true"></span>{{ __('home.why.numbers_note') }}</p>
            </div>
        @endif
    </div>
</x-ui.section>
