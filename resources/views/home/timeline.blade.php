@php
    $milestones = $page->milestones();
    $edition = $page->edition();
    $formatter = $page->formatter();
@endphp

@if ($milestones->isNotEmpty())
    <x-ui.section tone="sand" data-section="timeline" id="timeline" :container="false">
        <div class="container-site">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-ui.heading :eyebrow="__('home.timeline.eyebrow')" :title="__('home.timeline.title')" :lead="__('home.timeline.lead')" />
            </div>
        </div>

        <div x-data="scroller" class="mt-12">
            <ol
                x-ref="track"
                tabindex="0"
                aria-label="{{ __('home.timeline.title') }}"
                class="no-scrollbar track-gutter flex snap-x snap-mandatory gap-5 overflow-x-auto pb-4 focus-visible:outline-offset-[-3px]"
            >
                @foreach ($milestones as $milestone)
                    <li class="relative w-[min(82vw,22rem)] shrink-0 snap-start">
                        <article class="flex h-full flex-col overflow-hidden rounded-[1.75rem] bg-white shadow-soft ring-1 ring-ink/5">
                            @if ($milestone->image)
                                <div class="aspect-[16/10] overflow-hidden">
                                    <x-ui.img :key="$milestone->image" alt="" sizes="22rem" class="size-full object-cover" />
                                </div>
                            @else
                                <div class="relative aspect-[16/10] overflow-hidden bg-green text-white/15" aria-hidden="true">
                                    <x-ui.motif variant="jamdani" :size="40" />
                                    <p class="absolute bottom-4 left-5 font-display text-6xl font-semibold text-white">{{ $formatter->plain($milestone->happened_on->year) }}</p>
                                </div>
                            @endif
                            <div class="flex flex-1 flex-col p-6">
                                <p class="text-sm font-semibold text-green-700">{{ $milestone->date_label ?: $formatter->date($milestone->happened_on) }}</p>
                                <h3 class="mt-2 font-display text-xl leading-snug font-semibold text-navy">{{ $milestone->title }}</h3>
                                <p class="mt-2 leading-relaxed text-ink-soft">{{ $milestone->body }}</p>
                            </div>
                        </article>
                    </li>
                @endforeach

                @if ($edition)
                    <li class="relative w-[min(82vw,22rem)] shrink-0 snap-start" data-current-edition>
                        <article data-tone="midnight" class="relative isolate flex h-full flex-col overflow-hidden rounded-[1.75rem] bg-midnight p-6 text-white shadow-lift" style="--motif-1: #0e2a4f; --motif-2: #17375f; --motif-3: #3ddc97">
                            <x-ui.motif variant="tiles" class="absolute inset-0 -z-10 opacity-60" />
                            <p class="w-fit rounded-full bg-yellow px-3 py-1 text-xs font-semibold text-navy">{{ __('home.timeline.this_edition') }}</p>
                            <p class="mt-auto pt-24 text-sm font-semibold text-mint">{{ $page->dateRange() }}</p>
                            <h3 class="mt-2 font-display text-2xl leading-tight font-semibold text-white">{{ $edition->name }}</h3>
                            @if ($page->venueLine())
                                <p class="mt-2 text-white/75">{{ $page->venueLine() }}</p>
                            @endif
                        </article>
                    </li>
                @endif
            </ol>

            <div class="container-site mt-6 flex justify-end gap-2">
                <button type="button" x-on:click="scrollBy(-1)" x-bind:disabled="atStart" class="grid size-11 place-items-center rounded-full bg-white text-navy shadow-ring transition hover:bg-navy hover:text-white disabled:opacity-40 disabled:hover:bg-white disabled:hover:text-navy">
                    <x-ui.icon name="arrow-left" class="size-5" />
                    <span class="sr-only">{{ __('home.timeline.previous') }}</span>
                </button>
                <button type="button" x-on:click="scrollBy(1)" x-bind:disabled="atEnd" class="grid size-11 place-items-center rounded-full bg-white text-navy shadow-ring transition hover:bg-navy hover:text-white disabled:opacity-40 disabled:hover:bg-white disabled:hover:text-navy">
                    <x-ui.icon name="arrow-right" class="size-5" />
                    <span class="sr-only">{{ __('home.timeline.next') }}</span>
                </button>
            </div>
        </div>
    </x-ui.section>
@endif
