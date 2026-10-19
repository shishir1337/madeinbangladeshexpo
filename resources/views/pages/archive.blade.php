@inject('formatter', 'App\Support\Localization\LocaleFormatter')
@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php
    $breadcrumbs = [
        ['label' => __('site.home'), 'url' => localized_route('home')],
        ['label' => __('nav.items.archive.label')],
    ];

    $facts = array_values(array_filter([
        ['icon' => 'calendar', 'label' => __('pages/archive.facts.dates'), 'value' => $formatter->dateRange($edition->starts_on, $edition->ends_on)],
        $edition->venue ? ['icon' => 'map-pin', 'label' => __('pages/archive.facts.venue'), 'value' => "{$edition->venue->name}, {$edition->venue->city}"] : null,
        ['icon' => 'store', 'label' => __('pages/archive.facts.exhibitors'), 'value' => $formatter->number($exhibitors->count())],
        $days->isNotEmpty() ? ['icon' => 'clock', 'label' => __('pages/archive.facts.days'), 'value' => $formatter->number($days->count())] : null,
    ]));

    $dayTabs = $days->keys()->mapWithKeys(fn (string $day, int $index): array => [
        'day-'.($index + 1) => __('pages/archive.programme.day', ['number' => $formatter->plain($index + 1)]).' · '.$formatter->date(\Carbon\CarbonImmutable::parse($day)),
    ])->all();

    $time = fn (?string $value): ?string => $value === null ? null : $formatter->digits(substr($value, 0, 5));
@endphp

<x-layouts.site :title="__('pages/archive.meta_title').' · '.__('site.brand')" :description="__('pages/archive.meta_description')" image="expo25-welcome">
    <x-ui.page-hero
        variant="photo"
        :eyebrow="__('pages/archive.eyebrow')"
        :title="$edition->name"
        :lead="__('pages/archive.lead')"
        image="expo25-welcome"
        :image-alt="__('home.highlights.photos.expo25-welcome')"
        focus="center 35%"
        :breadcrumbs="$breadcrumbs"
    >
        <x-slot:facts>
            <x-ui.facts :items="$facts" />
        </x-slot:facts>
    </x-ui.page-hero>

    @if ($milestones->isNotEmpty())
        <x-ui.section tone="cream" id="journey">
            <div class="grid gap-12 lg:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)] lg:gap-16">
                <x-ui.heading :eyebrow="__('pages/archive.journey.eyebrow')" :title="__('pages/archive.journey.title')" class="lg:sticky lg:top-28 lg:self-start" />

                <ol class="relative space-y-6 border-l-2 border-sand pl-8">
                    @foreach ($milestones as $milestone)
                        <li class="relative" data-reveal data-reveal-delay="{{ $loop->index * 0.05 }}">
                            <span @class([
                                'absolute top-1.5 -left-[2.55rem] size-4 rounded-full ring-4 ring-cream',
                                'bg-green' => ! $loop->last,
                                'bg-yellow' => $loop->last,
                            ]) aria-hidden="true"></span>
                            <p class="text-sm font-semibold text-green">{{ $milestone->date_label ?: $formatter->date($milestone->happened_on) }}</p>
                            <h3 class="mt-1 font-display text-xl font-semibold text-navy">{{ $milestone->title }}</h3>
                            @if ($milestone->body)
                                <p class="mt-2 leading-relaxed text-ink-soft">{{ $milestone->body }}</p>
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>
        </x-ui.section>
    @endif

    @if ($days->isNotEmpty())
        <x-ui.section tone="white" id="programme">
            <x-ui.heading :eyebrow="__('pages/archive.programme.eyebrow')" :title="__('pages/archive.programme.title')" :lead="__('pages/archive.programme.lead')" />

            <x-ui.tabs id="programme-days" :tabs="$dayTabs" :label="__('pages/archive.programme.tabs_label')" class="mt-10">
                @foreach ($days->values() as $index => $sessions)
                    <x-ui.tab :name="'day-'.($index + 1)">
                        <ol class="divide-y divide-sand overflow-hidden rounded-[1.75rem] bg-cream ring-1 ring-sand">
                            @foreach ($sessions as $session)
                                <li class="grid gap-3 p-5 sm:grid-cols-[9rem_minmax(0,1fr)_auto] sm:items-center sm:gap-6 md:p-6">
                                    <p class="font-display text-lg font-semibold text-navy tabular">
                                        @if ($session->starts_at)
                                            {{ $time($session->starts_at) }}–{{ $time($session->ends_at) }}
                                        @else
                                            {{ __('pages/archive.programme.all_day') }}
                                        @endif
                                    </p>
                                    <p class="font-semibold leading-snug text-ink">{{ $session->title }}</p>
                                    <p><x-ui.chip :icon="$session->kind->icon()" :tone="$session->kind === \App\Enums\SessionKind::Matchmaking ? 'green' : 'neutral'">{{ $session->kind->label() }}</x-ui.chip></p>
                                </li>
                            @endforeach
                        </ol>
                    </x-ui.tab>
                @endforeach
            </x-ui.tabs>
        </x-ui.section>
    @endif

    @if ($exhibitors->isNotEmpty())
        <x-ui.section tone="sand" id="exhibitors">
            <x-ui.heading :eyebrow="__('pages/archive.exhibitors.eyebrow')" :title="__('pages/archive.exhibitors.title')" :lead="__('pages/archive.exhibitors.lead')" />

            <ul class="mt-10 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($exhibitors as $exhibitor)
                    <li class="flex items-center gap-4 rounded-2xl bg-white p-4 shadow-soft ring-1 ring-ink/5">
                        <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-green-50 font-display font-semibold text-green" aria-hidden="true">{{ mb_substr($exhibitor->name, 0, 1) }}</span>
                        <span class="min-w-0">
                            <span class="block font-semibold text-navy">{{ $exhibitor->name }}</span>
                            @if ($exhibitor->sector)
                                <a href="{{ localized_route('sectors.show', ['sector' => $exhibitor->sector]) }}" class="link-underline text-sm text-ink-soft hover:text-navy">{{ $exhibitor->sector->name }}</a>
                            @else
                                <span class="text-sm text-ink-soft">{{ __('pages/archive.exhibitors.no_sector') }}</span>
                            @endif
                        </span>
                    </li>
                @endforeach
            </ul>
        </x-ui.section>
    @endif

    @if ($albums->isNotEmpty())
        <x-ui.section tone="white" id="albums">
            <x-ui.heading :eyebrow="__('pages/archive.albums.eyebrow')" :title="__('pages/archive.albums.title')" />

            <div class="mt-10 grid gap-5 md:grid-cols-2">
                @foreach ($albums as $album)
                    <x-ui.album-card :album="$album" data-reveal data-reveal-delay="{{ $loop->index * 0.06 }}" />
                @endforeach
            </div>
        </x-ui.section>
    @endif

    @if ($videos->isNotEmpty())
        <x-ui.section tone="midnight" id="videos">
            <x-ui.heading :eyebrow="__('pages/archive.videos.eyebrow')" :title="__('pages/archive.videos.title')" />

            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($videos as $video)
                    <x-ui.youtube :id="$video->youtube_id" :title="$video->title" :poster="$video->poster" :caption="$video->speaker" />
                @endforeach
            </div>
        </x-ui.section>
    @endif

    <x-ui.section tone="cream" spacing="sm">
        <div class="flex flex-col gap-6 rounded-[2rem] bg-green p-8 text-white md:flex-row md:items-center md:justify-between md:p-10" data-tone="green">
            <div>
                <h2 class="font-display text-display-sm font-semibold text-white">{{ __('pages/archive.next.title') }}</h2>
                <p class="mt-2 text-white/80">{{ __('pages/archive.next.lead') }}</p>
            </div>
            <x-ui.button :href="localized_route('about')" variant="highlight" icon="arrow-right">{{ __('pages/archive.next.cta') }}</x-ui.button>
        </div>
    </x-ui.section>
</x-layouts.site>
