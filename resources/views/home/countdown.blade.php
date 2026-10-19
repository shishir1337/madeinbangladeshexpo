@php
    $state = $page->countdownState();
    $opening = $page->opening();
@endphp

@if ($state !== null)
    <section data-tone="cream" class="relative bg-cream pt-14 md:pt-20">
        <div class="container-site">
            <div data-countdown-state="{{ $state }}" class="relative isolate grid overflow-hidden rounded-[2rem] bg-midnight text-white shadow-lift lg:grid-cols-[minmax(0,1.35fr)_minmax(0,1fr)]" data-tone="midnight">
                <div class="absolute -bottom-24 -left-10 -z-10 size-72 rounded-full bg-green/50 blur-3xl" aria-hidden="true"></div>

                <div class="p-7 sm:p-10 lg:p-12">
                    @if ($state === 'upcoming')
                        @php
                            $parts = $page->countdownParts();
                        @endphp
                        <div x-data="countdown(@js($opening->toIso8601ZuluString()))" data-countdown-target="{{ $opening->toIso8601ZuluString() }}">
                            <div class="flex items-center justify-between gap-4">
                                <p class="eyebrow !text-mint">{{ __('home.countdown.upcoming') }}</p>
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
                            <dl class="mt-6 grid grid-cols-4 gap-2 sm:gap-4">
                                @foreach (['days', 'hours', 'minutes', 'seconds'] as $unit)
                                    <div class="flex flex-col-reverse rounded-2xl bg-white/[0.06] px-2 py-4 text-center ring-1 ring-white/10 sm:px-4 sm:py-5">
                                        <dt class="mt-2 text-[0.7rem] font-semibold tracking-[0.12em] text-white/60 uppercase sm:text-xs">{{ __("home.countdown.{$unit}") }}</dt>
                                        <dd class="font-display text-[clamp(2rem,1rem+4vw,4.25rem)] leading-none font-semibold tabular" x-text="parts.{{ $unit }}" aria-live="off">{{ $parts[$unit] }}</dd>
                                    </div>
                                @endforeach
                            </dl>
                            <p class="mt-6 text-sm text-white/70">
                                {{ __('home.countdown.opening', [
                                    'sp' => $page->clock($opening, 'America/Sao_Paulo'),
                                    'dhaka' => $page->clock($opening, 'Asia/Dhaka'),
                                ]) }}
                            </p>
                        </div>
                    @elseif ($state === 'live')
                        <p class="inline-flex items-center gap-2 rounded-full bg-crimson px-3 py-1 text-sm font-semibold text-white">
                            <span class="size-2 rounded-full bg-white animate-pulse-dot"></span>{{ __('home.countdown.live') }}
                        </p>
                        <p class="mt-5 font-display text-display-md font-semibold text-white">{{ __('home.countdown.live_lead') }}</p>
                    @else
                        <p class="eyebrow !text-mint">{{ __('home.countdown.past') }}</p>
                        <p class="mt-4 max-w-lg text-lead text-white/80">{{ __('home.countdown.past_lead') }}</p>
                        <x-ui.link href="#highlights" icon="arrow-down" class="mt-6">{{ __('home.countdown.past_cta') }}</x-ui.link>
                    @endif
                </div>

                <div class="grid gap-px bg-white/10 sm:grid-cols-2 lg:grid-cols-1">
                    @foreach (['America/Sao_Paulo' => 'sao_paulo', 'Asia/Dhaka' => 'dhaka'] as $timezone => $city)
                        @php
                            $now = now()->toImmutable();
                        @endphp
                        <div x-data="clock(@js($timezone))" class="flex items-center justify-between gap-6 bg-midnight-2 p-7 sm:p-8">
                            <div>
                                <p class="text-sm font-semibold text-white/60">{{ __("home.countdown.{$city}") }}</p>
                                <p class="mt-1 font-display text-display-md leading-none font-semibold tabular" x-text="time">{{ $page->clock($now, $timezone) }}</p>
                            </div>
                            <p class="flex items-center gap-2 rounded-full bg-white/[0.06] px-3 py-1.5 text-xs font-semibold text-white/75 ring-1 ring-white/10">
                                <span class="size-2 rounded-full" x-bind:class="open ? 'bg-mint' : 'bg-white/30'"></span>
                                <span x-text="open ? @js(__('home.countdown.office_hours')) : @js(__('home.countdown.after_hours'))">{{ __('home.countdown.local_time') }}</span>
                            </p>
                        </div>
                    @endforeach
                    <p class="bg-midnight-2 px-7 pb-6 text-sm text-white/55 sm:col-span-2 sm:px-8 lg:col-span-1">
                        {{ __('home.countdown.difference', ['hours' => $page->formatter()->plain($page->hoursAhead('America/Sao_Paulo', 'Asia/Dhaka'))]) }}
                    </p>
                </div>
            </div>
        </div>
    </section>
@endif
