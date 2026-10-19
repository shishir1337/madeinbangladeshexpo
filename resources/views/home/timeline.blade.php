@php
    $milestones = $page->milestones();
    $edition = $page->edition();
    $formatter = $page->formatter();
@endphp

{{-- Fifty years on one kantha thread: each milestone hangs below its year; the current edition closes the row. --}}
@if ($milestones->isNotEmpty())
    <x-ui.section tone="sand" data-section="timeline" id="timeline" :container="false" spacing="lg">
        <div class="container-site">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-ui.heading :eyebrow="__('home.timeline.eyebrow')" :title="__('home.timeline.title')" :lead="__('home.timeline.lead')" size="lg" />
            </div>
        </div>

        <div x-data="scroller" class="mt-14">
            <ol
                x-ref="track"
                tabindex="0"
                aria-label="{{ __('home.timeline.title') }}"
                class="no-scrollbar track-gutter relative flex snap-x snap-mandatory gap-5 overflow-x-auto pt-2 pb-6 focus-visible:outline-offset-[-3px]"
            >
                @foreach ($milestones as $milestone)
                    <li class="relative flex w-[min(80vw,21rem)] shrink-0 snap-start flex-col">
                        <div class="relative flex items-center gap-3 pb-5 text-green/40">
                            <span class="relative z-10 size-4 shrink-0 rounded-full border-[3px] border-cream-2 bg-green shadow-[0_0_0_2px_var(--color-green)]" aria-hidden="true"></span>
                            <span class="stitch-x absolute top-2 -right-5 left-0 -mt-px" aria-hidden="true"></span>
                            <span class="relative z-10 bg-cream-2 pr-2 font-display text-3xl leading-none font-bold text-green">{{ $formatter->plain($milestone->happened_on->year) }}</span>
                        </div>
                        <article class="group flex flex-1 flex-col overflow-hidden rounded-[1.5rem] bg-white shadow-soft ring-1 ring-ink/5 transition duration-500 hover:-translate-y-1 hover:shadow-lift">
                            @if ($milestone->image)
                                <div class="aspect-[16/10] overflow-hidden">
                                    <x-ui.img :key="$milestone->image" alt="" sizes="21rem" class="size-full object-cover transition duration-[1.2s] group-hover:scale-105" />
                                </div>
                            @else
                                <div class="relative aspect-[16/10] overflow-hidden bg-green text-white/20" aria-hidden="true">
                                    <x-ui.motif variant="jamdani" :size="44" class="absolute inset-0 transition duration-[1.2s] group-hover:scale-110" />
                                    <p class="absolute bottom-4 left-5 font-display text-6xl leading-none font-bold text-white/90">{{ $formatter->plain($milestone->happened_on->year) }}</p>
                                </div>
                            @endif
                            <div class="flex flex-1 flex-col p-6">
                                <p class="text-sm font-semibold text-green-700">{{ $milestone->date_label ?: $formatter->date($milestone->happened_on) }}</p>
                                <h3 class="mt-2 font-display text-xl leading-snug font-bold text-navy">{{ $milestone->title }}</h3>
                                <p class="mt-2 leading-relaxed text-ink-soft">{{ $milestone->body }}</p>
                            </div>
                        </article>
                    </li>
                @endforeach

                @if ($edition)
                    <li class="relative flex w-[min(80vw,21rem)] shrink-0 snap-start flex-col" data-current-edition>
                        <div class="relative flex items-center gap-3 pb-5">
                            <span class="relative z-10 size-4 shrink-0 rounded-full bg-yellow shadow-[0_0_0_3px_var(--color-cream-2),0_0_0_5px_var(--color-navy)]" aria-hidden="true"></span>
                            <span class="relative z-10 font-display text-3xl leading-none font-bold text-navy">{{ __('home.timeline.this_edition') }}</span>
                        </div>
                        <article data-tone="midnight" class="relative isolate flex flex-1 flex-col overflow-hidden rounded-[1.5rem] bg-midnight p-6 text-white shadow-lift">
                            <svg class="absolute -right-10 -bottom-10 -z-10 w-48 opacity-90" viewBox="0 0 40 40" aria-hidden="true" focusable="false">
                                <circle cx="15" cy="20" r="11" fill="#e8283f" />
                                <circle cx="25" cy="20" r="11" fill="#2456d6" />
                                <path d="M20 10.4a11 11 0 0 1 0 19.2 11 11 0 0 1 0-19.2Z" fill="#004f3a" />
                            </svg>
                            <p class="w-fit rounded-full bg-yellow px-3 py-1 text-xs font-semibold text-navy">{{ $page->dateRange() }}</p>
                            <h3 class="mt-auto pt-24 font-display text-2xl leading-tight font-bold text-white">{{ $edition->name }}</h3>
                            @if ($page->venueLine())
                                <p class="mt-2 max-w-[13rem] text-white/75">{{ $page->venueLine() }}</p>
                            @endif
                        </article>
                    </li>
                @endif
            </ol>

            <div class="container-site mt-4 flex justify-end gap-2">
                <button type="button" x-on:click="scrollBy(-1)" x-bind:disabled="atStart" class="grid size-12 place-items-center rounded-full bg-white text-navy shadow-ring transition hover:bg-navy hover:text-white disabled:opacity-40 disabled:hover:bg-white disabled:hover:text-navy">
                    <x-ui.icon name="arrow-left" class="size-5" />
                    <span class="sr-only">{{ __('home.timeline.previous') }}</span>
                </button>
                <button type="button" x-on:click="scrollBy(1)" x-bind:disabled="atEnd" class="grid size-12 place-items-center rounded-full bg-white text-navy shadow-ring transition hover:bg-navy hover:text-white disabled:opacity-40 disabled:hover:bg-white disabled:hover:text-navy">
                    <x-ui.icon name="arrow-right" class="size-5" />
                    <span class="sr-only">{{ __('home.timeline.next') }}</span>
                </button>
            </div>
        </div>
    </x-ui.section>
@endif
