@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php
    $state = $page->countdownState();
    $opening = $page->opening();
    $edition = $page->edition();
    $formatter = $page->formatter();
@endphp

{{--
    The edition as a boarding pass from Dhaka (DAC) to São Paulo (GRU): dates, venue and opening time on the pass,
    the countdown on a departure-board stub. Before the opening it counts down; during the expo it says so; after
    it, it points to how the edition went.
--}}
@if ($state !== null)
    <section data-section="ticket" data-tone="cream" class="relative bg-cream pt-14 pb-10 md:pt-20 md:pb-14">
        <div class="container-site">
            <div class="ticket" data-reveal>
                <article data-countdown-state="{{ $state }}" class="flex flex-col lg:flex-row" style="--stub: var(--color-midnight)">
                    <div class="ticket-part flex-1 rounded-t-[1.75rem] p-6 sm:p-8 lg:rounded-tr-none lg:rounded-l-[1.75rem] lg:p-10">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <p class="woven-label woven-label--green">{{ __('home.ticket.label') }}</p>
                            <p class="text-sm font-semibold text-ink-soft">{{ $edition->name }}</p>
                        </div>

                        <div class="mt-8 grid grid-cols-[auto_minmax(0,1fr)_auto] items-center gap-4 sm:gap-8">
                            <div>
                                <p class="font-display text-[clamp(2.8rem,1.6rem+4.6vw,5.5rem)] leading-none font-bold tracking-[-0.03em] text-navy">DAC</p>
                                <p class="mt-2 flex items-center gap-2 text-sm font-semibold text-ink-soft"><span class="size-2.5 rounded-full bg-sun" aria-hidden="true"></span>{{ __('home.countdown.dhaka') }}</p>
                            </div>
                            <div class="relative -mt-7 h-8 overflow-hidden text-sand-2" aria-hidden="true">
                                <div class="stitch-x absolute inset-x-0 top-1/2 -mt-px"></div>
                                <div class="ticket-flight absolute inset-0 flex items-center">
                                    <span class="grid size-8 place-items-center rounded-full bg-[var(--paper)] text-navy">
                                        <x-ui.icon name="plane" class="size-5 rotate-45" />
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-display text-[clamp(2.8rem,1.6rem+4.6vw,5.5rem)] leading-none font-bold tracking-[-0.03em] text-navy">GRU</p>
                                <p class="mt-2 flex items-center justify-end gap-2 text-sm font-semibold text-ink-soft">{{ __('home.countdown.sao_paulo') }}<span class="size-2.5 rounded-full bg-globe" aria-hidden="true"></span></p>
                            </div>
                        </div>

                        <dl class="mt-8 grid gap-x-8 gap-y-5 border-t-2 border-dashed border-sand pt-6 sm:grid-cols-3">
                            <div>
                                <dt class="text-xs font-semibold tracking-[0.14em] text-ink-soft uppercase">{{ __('home.hero.facts.dates') }}</dt>
                                <dd class="mt-1.5 font-display text-xl leading-tight font-semibold text-navy">{{ $page->dateRange() }}</dd>
                            </div>
                            @if ($venueLine = $page->venueLine())
                                <div>
                                    <dt class="text-xs font-semibold tracking-[0.14em] text-ink-soft uppercase">{{ __('home.hero.facts.venue') }}</dt>
                                    <dd class="mt-1.5 font-display text-xl leading-tight font-semibold text-navy">{{ $venueLine }}</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-xs font-semibold tracking-[0.14em] text-ink-soft uppercase">{{ __('home.ticket.doors') }}</dt>
                                <dd class="mt-1.5 font-display text-xl leading-tight font-semibold text-navy">{{ __('home.ticket.doors_value', ['sp' => $page->clock($opening, 'America/Sao_Paulo'), 'dhaka' => $page->clock($opening, 'Asia/Dhaka')]) }}</dd>
                            </div>
                        </dl>

                        <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-3 rounded-2xl bg-cream px-4 py-3 text-sm">
                            @foreach (['America/Sao_Paulo' => 'sao_paulo', 'Asia/Dhaka' => 'dhaka'] as $timezone => $city)
                                <p x-data="clock(@js($timezone))" class="flex items-center gap-2 text-ink">
                                    <span class="size-2 rounded-full bg-sand-2" x-bind:class="open ? '!bg-green-700' : ''" aria-hidden="true"></span>
                                    <span class="text-ink-soft">{{ __("home.ticket.now_in", ['city' => __("home.countdown.{$city}")]) }}</span>
                                    <span class="font-semibold tabular" x-text="time">{{ $page->clock(now()->toImmutable(), $timezone) }}</span>
                                    <span class="text-xs text-ink-soft" x-text="open ? @js(__('home.countdown.office_hours')) : @js(__('home.countdown.after_hours'))"></span>
                                </p>
                            @endforeach
                            <p class="text-ink-soft">{{ __('home.countdown.difference', ['hours' => $formatter->plain($page->hoursAhead('America/Sao_Paulo', 'Asia/Dhaka'))]) }}</p>
                        </div>
                    </div>

                    <div class="ticket-perforation" aria-hidden="true"></div>

                    <div data-tone="midnight" class="relative flex flex-col justify-center rounded-b-[1.75rem] bg-midnight p-6 text-white sm:p-8 lg:w-[25rem] lg:rounded-r-[1.75rem] lg:rounded-bl-none lg:p-10">
                        @if ($state === 'upcoming')
                            @php
                                $values = $page->countdownValues();
                                $strip = $page->digitStrip();
                                $widths = ['days' => max(2, strlen((string) $values['days'])), 'hours' => 2, 'minutes' => 2, 'seconds' => 2];
                            @endphp
                            <div x-data="countdown(@js($opening->toIso8601ZuluString()))" data-countdown-target="{{ $opening->toIso8601ZuluString() }}">
                                <div class="flex items-center justify-between gap-4">
                                    <p class="text-xs font-semibold tracking-[0.16em] text-yellow uppercase">{{ __('home.countdown.upcoming') }}</p>
                                    <button
                                        type="button"
                                        x-on:click="toggle()"
                                        class="grid size-9 place-items-center rounded-full text-white/70 ring-1 ring-white/15 transition hover:bg-white/10 hover:text-white"
                                        x-bind:aria-label="paused ? @js(__('home.countdown.resume')) : @js(__('home.countdown.pause'))"
                                        aria-label="{{ __('home.countdown.pause') }}"
                                    >
                                        <x-ui.icon name="pause" class="size-4" x-show="! paused" />
                                        <x-ui.icon name="play" class="size-4" x-show="paused" x-cloak />
                                    </button>
                                </div>

                                <dl class="mt-5 grid grid-cols-4 gap-2">
                                    @foreach ($widths as $unit => $width)
                                        @php($padded = str_pad((string) $values[$unit], $width, '0', STR_PAD_LEFT))
                                        <div class="flex flex-col-reverse items-center">
                                            <dt class="mt-2 text-[0.68rem] font-semibold tracking-[0.12em] text-white/55 uppercase">{{ __("home.countdown.{$unit}") }}</dt>
                                            <dd class="flex gap-0.5">
                                                <span class="sr-only" x-text="parts.{{ $unit }}">{{ $page->countdownParts()[$unit] }}</span>
                                                @for ($column = 0; $column < $width; $column++)
                                                    <span class="flap relative grid place-items-center rounded-md bg-midnight-2 px-[0.14em] font-display text-[clamp(1.55rem,1.2rem+1vw,2.15rem)] font-semibold text-white tabular ring-1 ring-white/10" aria-hidden="true">
                                                        <span class="odometer">
                                                            <span class="odometer-strip" style="transform: translate3d(0, {{ -10 * (int) $padded[$column] }}%, 0)" x-bind:style="{ transform: `translate3d(0, ${digit('{{ $unit }}', {{ $width }}, {{ $column }}) * -10}%, 0)` }">
                                                                @foreach ($strip as $glyph)
                                                                    <span>{{ $glyph }}</span>
                                                                @endforeach
                                                            </span>
                                                        </span>
                                                    </span>
                                                @endfor
                                            </dd>
                                        </div>
                                    @endforeach
                                </dl>

                                <p class="mt-6 text-sm leading-relaxed text-white/70">{{ __('home.ticket.stub_lead') }}</p>
                                @if ($navigation->has('register'))
                                    <x-ui.button :href="localized_route('register')" variant="highlight" icon="arrow-right" class="mt-5 w-full">{{ __('home.hero.cta_buyer') }}</x-ui.button>
                                @endif
                            </div>
                        @elseif ($state === 'live')
                            <p class="inline-flex w-fit items-center gap-2 rounded-full bg-crimson px-3 py-1 text-sm font-semibold text-white">
                                <span class="size-2 rounded-full bg-white animate-pulse-dot"></span>{{ __('home.countdown.live') }}
                            </p>
                            <p class="mt-5 font-display text-display-sm font-semibold text-white">{{ __('home.countdown.live_lead') }}</p>
                        @else
                            <p class="text-xs font-semibold tracking-[0.16em] text-yellow uppercase">{{ __('home.countdown.past') }}</p>
                            <p class="mt-4 leading-relaxed text-white/80">{{ __('home.countdown.past_lead') }}</p>
                            <x-ui.link href="#highlights" icon="arrow-down" class="mt-6">{{ __('home.countdown.past_cta') }}</x-ui.link>
                        @endif
                    </div>
                </article>
            </div>
        </div>
    </section>
@endif
