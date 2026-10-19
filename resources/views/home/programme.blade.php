@php
    $past = $page->lastPastEdition();
    $formatter = $page->formatter();
    $year = $past && ctype_digit((string) $past->slug) ? $formatter->plain((int) $past->slug) : null;

    $formats = [
        ['key' => 'exhibition', 'photo' => 'expo25-stand-sts', 'count' => $past?->exhibitors_count, 'position' => 'object-[center_30%]'],
        ['key' => 'meetings', 'photo' => 'expo25-stand-accessories', 'count' => $past?->matchmaking_count, 'position' => 'object-center'],
        ['key' => 'seminars', 'photo' => 'expo25-speaker-joynal-abdin', 'count' => $past?->seminar_count, 'position' => 'object-[60%_center]'],
        ['key' => 'ceremonies', 'photo' => 'expo25-guests', 'count' => $past?->ceremony_count, 'position' => 'object-center'],
    ];
@endphp

{{-- What happens at the expo, with what the last edition actually had. --}}
<x-ui.section tone="white" data-section="programme" id="programme" spacing="lg">
    <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(0,0.8fr)] lg:items-end">
        <x-ui.heading :eyebrow="__('home.programme.eyebrow')" :title="__('home.programme.title')" size="lg" />
        <p class="max-w-md text-lead text-ink-soft lg:justify-self-end" data-reveal>{{ __('home.programme.lead') }}</p>
    </div>

    <ol class="swipe-row mt-14 sm:grid sm:grid-cols-2 sm:gap-5 lg:grid-cols-4" tabindex="0" aria-label="{{ __('home.programme.title') }}">
        @foreach ($formats as $format)
            <li data-reveal @class(['lg:mt-12' => $loop->odd === false])>
                <article class="group flex h-full flex-col">
                    <div class="relative aspect-[4/5] overflow-hidden rounded-[1.5rem] bg-cream-2">
                        <x-ui.img :key="$format['photo']" :alt="__('home.programme.'.$format['key'].'.photo')" sizes="(min-width: 1024px) 22vw, (min-width: 640px) 45vw, 80vw" :class="'size-full object-cover transition duration-[1.2s] ease-[var(--ease-out-quint)] group-hover:scale-105 '.$format['position']" data-reveal="zoom" />
                        <div class="absolute inset-0 bg-gradient-to-t from-midnight/75 via-transparent to-transparent" aria-hidden="true"></div>
                        <p class="absolute top-4 left-4 grid size-10 place-items-center rounded-full bg-white/90 font-display text-sm font-bold text-navy backdrop-blur" aria-hidden="true">{{ $formatter->plain(0) }}{{ $formatter->plain($loop->iteration) }}</p>
                        @if ($format['count'] && $year)
                            <p class="absolute right-4 bottom-4 left-4 flex items-end gap-2 text-white">
                                <span class="font-display text-4xl leading-none font-bold text-yellow">{{ $formatter->plain($format['count']) }}</span>
                                <span class="pb-0.5 text-sm leading-snug text-white/85">{{ trans_choice('home.programme.'.$format['key'].'.count', $format['count'], ['year' => $year]) }}</span>
                            </p>
                        @endif
                    </div>
                    <h3 class="mt-5 font-display text-2xl font-bold tracking-[-0.01em] text-navy">{{ __('home.programme.'.$format['key'].'.title') }}</h3>
                    <p class="mt-2 leading-relaxed text-ink-soft">{{ __('home.programme.'.$format['key'].'.body') }}</p>
                </article>
            </li>
        @endforeach
    </ol>
</x-ui.section>
