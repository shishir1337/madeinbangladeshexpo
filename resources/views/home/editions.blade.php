@inject('navigation', 'App\Support\Navigation\SiteNavigation')
@inject('shell', 'App\View\SiteShell')

@php
    $editions = $page->editions();
    $current = $page->edition();
    $formatter = $page->formatter();
    $number = fn (int $value): string => ($value < 10 ? $formatter->plain(0) : '').$formatter->plain($value);
    $editionLabel = fn (\App\Models\Edition $edition): string => __('home.hero.edition')[$edition->number] ?? __('home.hero.edition.n', ['number' => $formatter->plain($edition->number)]);
@endphp

{{--
    The expo as a series: every edition in order on one thread, what happened at the ones already held, the one
    being prepared, and an open place for the next. New editions appear here as staff add them.
--}}
@if ($editions->isNotEmpty())
    <section data-section="editions" data-tone="green" class="relative isolate overflow-hidden bg-green-900 py-20 text-white md:py-28">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(70%_60%_at_15%_0%,rgb(0_79_58/0.9),transparent_70%),radial-gradient(50%_50%_at_95%_100%,rgb(36_86_214/0.25),transparent_70%)]" aria-hidden="true"></div>

        <div class="container-site">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(0,0.8fr)] lg:items-end">
                <x-ui.heading :eyebrow="__('home.editions.eyebrow')" :title="__('home.editions.title')" size="lg" />
                <p class="max-w-md text-lead text-white/75 lg:justify-self-end" data-reveal>{{ __('home.editions.lead') }}</p>
            </div>

            <ol class="relative mt-16 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                <span class="stitch-x absolute -top-6 right-8 left-8 hidden text-white/25 xl:block" aria-hidden="true"></span>

                @foreach ($editions as $edition)
                    @php
                        $past = $edition->isPast();
                        $isCurrent = $current?->is($edition);
                        $year = ctype_digit((string) $edition->slug) ? $formatter->plain((int) $edition->slug) : $edition->name;
                    @endphp
                    <li data-edition="{{ $edition->slug }}" class="relative" data-reveal>
                        <span @class([
                            'absolute -top-[1.85rem] left-8 hidden size-3.5 rounded-full ring-4 ring-green-900 xl:block',
                            'bg-white/60' => $past,
                            'bg-yellow' => ! $past,
                        ]) aria-hidden="true"></span>

                        <article @class([
                            'group relative flex h-full flex-col overflow-hidden rounded-[1.75rem]',
                            'bg-white/[0.06] ring-1 ring-white/12' => $past,
                            'bg-cream text-ink shadow-float' => ! $past,
                        ]) @if (! $past) data-tone="cream" @endif>
                            @if ($past && ($cover = $edition->galleryAlbums->first()))
                                <div class="relative aspect-[16/9] overflow-hidden">
                                    <x-ui.img :key="$cover->cover" :alt="$cover->title" sizes="(min-width: 1280px) 26rem, (min-width: 768px) 45vw, 92vw" class="size-full object-cover transition duration-[1.2s] group-hover:scale-105" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-green-900 via-green-900/30 to-transparent" aria-hidden="true"></div>
                                    <p class="absolute top-4 left-4 woven-label woven-label--dark">{{ __('home.editions.status.held') }}</p>
                                </div>
                            @endif

                            <div class="flex flex-1 flex-col p-7 md:p-8">
                                <div class="flex items-baseline justify-between gap-4">
                                    <p @class(['font-display text-sm font-semibold tracking-[0.16em] uppercase', 'text-white/60' => $past, 'text-green-700' => ! $past])>N° {{ $number($edition->number) }} · {{ $editionLabel($edition) }}</p>
                                    @if ($isCurrent)
                                        <span class="woven-label woven-label--yellow shrink-0">{{ __('home.editions.status.current') }}</span>
                                    @endif
                                </div>
                                <h3 @class(['mt-3 font-display text-[clamp(3rem,2.2rem+2.4vw,4.5rem)] leading-none font-bold tracking-[-0.04em]', 'text-white' => $past, 'text-navy' => ! $past])>{{ $year }}</h3>
                                <p @class(['mt-4 font-semibold', 'text-white' => $past, 'text-navy' => ! $past])>{{ $formatter->dateRange($edition->starts_on, $edition->ends_on) }}</p>
                                @if ($edition->venue)
                                    <p @class(['mt-1 text-sm', 'text-white/65' => $past, 'text-ink-soft' => ! $past])>{{ $edition->venue->name }}, {{ $edition->venue->cityName() }}</p>
                                @endif

                                @if ($past)
                                    <dl class="mt-7 grid grid-cols-2 gap-3">
                                        @foreach (['exhibitors' => $edition->exhibitors_count, 'matchmaking' => $edition->matchmaking_count, 'seminars' => $edition->seminar_count, 'photos' => $edition->gallery_photos_count] as $key => $count)
                                            @if ($count > 0)
                                                <div class="rounded-2xl bg-white/[0.06] px-4 py-3 ring-1 ring-white/10">
                                                    <dt class="sr-only">{{ trans_choice("home.editions.stats.{$key}", $count) }}</dt>
                                                    <dd class="flex flex-col">
                                                        <span class="font-display text-3xl leading-none font-bold text-yellow tabular">{{ $formatter->plain($count) }}</span>
                                                        <span class="mt-1 text-xs leading-snug text-white/70">{{ trans_choice("home.editions.stats.{$key}", $count) }}</span>
                                                    </dd>
                                                </div>
                                            @endif
                                        @endforeach
                                    </dl>
                                    @if ($navigation->has('archive'))
                                        <p class="mt-auto pt-7"><x-ui.link :href="localized_route('archive')">{{ __('home.editions.archive', ['year' => $year]) }}</x-ui.link></p>
                                    @endif
                                @else
                                    <p class="mt-6 leading-relaxed text-ink-soft">{{ __('home.editions.current_body') }}</p>
                                    @if ($isCurrent)
                                        <ul class="mt-6 space-y-2.5 border-t-2 border-dashed border-sand pt-5 text-[0.95rem] text-ink">
                                            @if ($daysToGo = $shell->daysToGoLabel())
                                                <li class="flex items-center gap-3"><x-ui.icon name="calendar" class="size-5 text-green" />{{ $daysToGo }}</li>
                                            @endif
                                            @if (($sectorCount = $page->sectors()->count()) > 0)
                                                <li class="flex items-center gap-3"><x-ui.icon name="layers" class="size-5 text-green" />{{ __('home.hero.facts.sectors_value', ['count' => $formatter->plain($sectorCount)]) }}</li>
                                            @endif
                                            <li class="flex items-center gap-3"><x-ui.icon name="ticket" class="size-5 text-green" />{{ __('home.hero.free_badge') }}</li>
                                        </ul>
                                    @endif
                                    <div class="mt-auto flex flex-wrap gap-3 pt-7">
                                        @if ($navigation->has('apply'))
                                            <x-ui.button :href="localized_route('apply')" icon="arrow-right">{{ __('home.hero.cta_exhibit') }}</x-ui.button>
                                        @endif
                                        @if ($navigation->has('register'))
                                            <x-ui.button :href="localized_route('register')" variant="secondary">{{ __('home.hero.cta_buyer') }}</x-ui.button>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </article>
                    </li>
                @endforeach

                <li class="relative" data-reveal>
                    <span class="absolute -top-[1.85rem] left-8 hidden size-3.5 rounded-full border-2 border-dashed border-white/50 bg-green-900 xl:block" aria-hidden="true"></span>
                    <article class="relative isolate flex h-full flex-col overflow-hidden rounded-[1.75rem] border-2 border-dashed border-white/25 p-7 md:p-8">
                        {{-- The mark still to be drawn: the two discs in outline. --}}
                        <svg class="absolute -right-12 -bottom-16 -z-10 w-72 text-white/15" viewBox="0 0 40 30" fill="none" stroke="currentColor" stroke-width="0.4" stroke-dasharray="1.2 1" aria-hidden="true" focusable="false">
                            <circle cx="15" cy="15" r="11" />
                            <circle cx="25" cy="15" r="11" />
                            <path d="M20 9 26 15 20 21 14 15Z" />
                        </svg>
                        <p class="font-display text-sm font-semibold tracking-[0.16em] text-white/60 uppercase">N° {{ $number(($editions->max('number') ?? 0) + 1) }}</p>
                        <h3 class="mt-3 font-display text-[clamp(2.4rem,1.8rem+2vw,3.5rem)] leading-none font-bold tracking-[-0.03em] text-white">{{ __('home.editions.next_title') }}</h3>
                        <p class="mt-5 leading-relaxed text-white/75">{{ __('home.editions.next_body') }}</p>
                        <div class="mt-auto pt-8">
                            <x-ui.button href="#updates" variant="on-dark" icon="arrow-down">{{ __('home.editions.next_cta') }}</x-ui.button>
                        </div>
                    </article>
                </li>
            </ol>
        </div>
    </section>
@endif
