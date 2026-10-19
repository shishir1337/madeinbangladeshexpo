@inject('shell', 'App\View\SiteShell')
@inject('settings', 'App\Settings\GeneralSettings')
@inject('formatter', 'App\Support\Localization\LocaleFormatter')

@php
    $breadcrumbs = [
        ['label' => __('site.home'), 'url' => localized_route('home')],
        ['label' => __('nav.items.organiser.label')],
    ];

    $objectives = [
        'trade' => 'trending-up',
        'advocacy' => 'megaphone',
        'knowledge' => 'file-text',
        'capacity' => 'layers',
        'culture' => 'palette',
        'networking' => 'users',
    ];

    $services = [
        'matchmaking' => 'puzzle',
        'intelligence' => 'search',
        'promotion' => 'store',
        'investment' => 'banknote',
        'advisory' => 'briefcase',
        'advocacy' => 'globe',
        'training' => 'award',
    ];

    $memberships = ['corporate' => 'building', 'individual' => 'user', 'associate' => 'landmark'];
    $mapUrl = 'https://www.google.com/maps/search/?api=1&query='.rawurlencode($settings->office_address);
@endphp

<x-layouts.site :title="__('pages/organiser.meta_title').' · '.__('site.brand')" :description="__('pages/organiser.meta_description')" image="bbcci-bgmea-2024">
    @push('head')
        <x-seo.json-ld :data="$structuredData" />
    @endpush

    <x-ui.page-hero
        :eyebrow="__('pages/organiser.eyebrow')"
        :title="__('pages/organiser.title')"
        :lead="__('pages/organiser.lead')"
        image="bbcci-bgmea-2024"
        :image-alt="__('pages/organiser.image_alt')"
        :breadcrumbs="$breadcrumbs"
    />

    <x-ui.section tone="white" id="mission">
        <div class="grid gap-5 lg:grid-cols-2">
            @foreach (['mission' => 'target', 'vision' => 'eye'] as $key => $icon)
                <div @class([
                    'relative overflow-hidden rounded-[2rem] p-8 md:p-10',
                    'bg-green text-white' => $loop->first,
                    'bg-cream ring-1 ring-sand' => ! $loop->first,
                ]) @if ($loop->first) data-tone="green" @endif data-reveal data-reveal-delay="{{ $loop->index * 0.08 }}">
                    @if ($loop->first)
                        <x-ui.motif variant="jamdani" class="absolute inset-y-0 right-0 w-1/2 text-white/10 [mask-image:linear-gradient(to_left,black,transparent)]" />
                    @endif
                    <span @class(['relative grid size-12 place-items-center rounded-2xl', 'bg-white/15 text-yellow' => $loop->first, 'bg-white text-green ring-1 ring-ink/5' => ! $loop->first])>
                        <x-ui.icon :name="$icon" class="size-6" />
                    </span>
                    <h2 class="relative mt-6 font-display text-display-sm font-semibold text-navy on-dark:text-white">{{ __("pages/organiser.{$key}.title") }}</h2>
                    <p class="relative mt-4 text-lead leading-relaxed text-ink-soft on-dark:text-white/85">{{ __("pages/organiser.{$key}.body") }}</p>
                </div>
            @endforeach
        </div>
    </x-ui.section>

    <x-ui.section tone="cream" id="objectives">
        <x-ui.heading :eyebrow="__('pages/organiser.objectives.eyebrow')" :title="__('pages/organiser.objectives.title')" />

        <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($objectives as $key => $icon)
                <article class="flex gap-4 rounded-[1.5rem] bg-white p-6 shadow-soft ring-1 ring-ink/5" data-reveal data-reveal-delay="{{ $loop->index * 0.05 }}">
                    <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-green-50 text-green">
                        <x-ui.icon :name="$icon" class="size-5" />
                    </span>
                    <div>
                        <h3 class="font-display text-lg leading-snug font-semibold text-navy">{{ __("pages/organiser.objectives.items.{$key}.title") }}</h3>
                        <p class="mt-1.5 leading-relaxed text-ink-soft">{{ __("pages/organiser.objectives.items.{$key}.body") }}</p>
                    </div>
                </article>
            @endforeach
        </div>
    </x-ui.section>

    <x-ui.section tone="midnight" id="services">
        <x-ui.heading :eyebrow="__('pages/organiser.services.eyebrow')" :title="__('pages/organiser.services.title')" />

        <ul class="mt-12 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($services as $key => $icon)
                <li @class([
                    'flex items-center gap-4 rounded-2xl bg-white/[0.06] p-5 ring-1 ring-white/10',
                    'lg:col-span-2' => $loop->last,
                ]) data-reveal data-reveal-delay="{{ $loop->index * 0.04 }}">
                    <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-white/10 text-yellow">
                        <x-ui.icon :name="$icon" class="size-5" />
                    </span>
                    <span class="font-semibold leading-snug">{{ __("pages/organiser.services.items.{$key}") }}</span>
                </li>
            @endforeach
        </ul>
    </x-ui.section>

    <x-ui.section tone="white" id="governance">
        <div class="grid gap-12 lg:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)] lg:gap-16">
            <x-ui.heading :eyebrow="__('pages/organiser.governance.eyebrow')" :title="__('pages/organiser.governance.title')" />

            <ol class="relative space-y-4 before:absolute before:top-6 before:bottom-6 before:left-[1.85rem] before:w-px before:bg-sand">
                <li class="relative flex gap-5 rounded-[1.5rem] bg-cream p-6 ring-1 ring-sand">
                    <span class="relative z-10 grid size-12 shrink-0 place-items-center rounded-2xl bg-navy font-display text-lg font-semibold text-white tabular">{{ $formatter->plain(18) }}</span>
                    <div>
                        <h3 class="font-display text-xl font-semibold text-navy">{{ __('pages/organiser.governance.board.title') }}</h3>
                        <p class="mt-1 leading-relaxed text-ink-soft">{{ __('pages/organiser.governance.board.body') }}</p>
                    </div>
                </li>
                <li class="relative flex gap-5 rounded-[1.5rem] bg-cream p-6 ring-1 ring-sand">
                    <span class="relative z-10 grid size-12 shrink-0 place-items-center rounded-2xl bg-green font-display text-lg font-semibold text-white tabular">{{ $formatter->plain(4) }}</span>
                    <div>
                        <h3 class="font-display text-xl font-semibold text-navy">{{ __('pages/organiser.governance.executive.title') }}</h3>
                        <p class="mt-1 leading-relaxed text-ink-soft">{{ __('pages/organiser.governance.executive.body') }}</p>
                    </div>
                </li>
                <li class="relative flex gap-5 rounded-[1.5rem] bg-cream p-6 ring-1 ring-sand">
                    <span class="relative z-10 grid size-12 shrink-0 place-items-center rounded-2xl bg-yellow font-display text-lg font-semibold text-navy tabular">{{ $formatter->plain(3) }}</span>
                    <div>
                        <h3 class="font-display text-xl font-semibold text-navy">{{ __('pages/organiser.governance.committees.title') }}</h3>
                        <ul class="mt-3 flex flex-wrap gap-2">
                            @foreach (__('pages/organiser.governance.committees.items') as $committee)
                                <li><x-ui.chip>{{ $committee }}</x-ui.chip></li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            </ol>
        </div>
    </x-ui.section>

    @if ($leaders->isNotEmpty())
        <x-ui.section tone="sand" id="leadership">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-ui.heading :eyebrow="__('pages/organiser.leaders.eyebrow')" :title="__('pages/organiser.leaders.title')" />
                <x-ui.link :href="localized_route('committee')">{{ __('pages/organiser.leaders.all') }}</x-ui.link>
            </div>

            <div class="mt-12 grid gap-5 md:grid-cols-3">
                @foreach ($leaders as $person)
                    <x-ui.person :person="$person" data-reveal data-reveal-delay="{{ $loop->index * 0.06 }}" />
                @endforeach
            </div>
        </x-ui.section>
    @endif

    <x-ui.section tone="white" id="membership">
        <x-ui.heading :eyebrow="__('pages/organiser.membership.eyebrow')" :title="__('pages/organiser.membership.title')" :lead="__('pages/organiser.membership.lead')" />

        <div class="mt-12 grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] lg:gap-12">
            <div>
                <h3 class="font-display text-xl font-semibold text-navy">{{ __('pages/organiser.membership.types_title') }}</h3>
                <div class="mt-5 space-y-3">
                    @foreach ($memberships as $key => $icon)
                        <div class="flex gap-4 rounded-[1.5rem] bg-cream p-5 ring-1 ring-sand">
                            <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-white text-navy ring-1 ring-ink/5">
                                <x-ui.icon :name="$icon" class="size-5" />
                            </span>
                            <div>
                                <p class="font-display text-lg font-semibold text-navy">{{ __("pages/organiser.membership.types.{$key}.title") }}</p>
                                <p class="mt-1 leading-relaxed text-ink-soft">{{ __("pages/organiser.membership.types.{$key}.body") }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col rounded-[2rem] bg-green p-7 text-white md:p-9" data-tone="green">
                <h3 class="font-display text-xl font-semibold">{{ __('pages/organiser.membership.benefits_title') }}</h3>
                <ul class="mt-5 space-y-3">
                    @foreach (__('pages/organiser.membership.benefits') as $benefit)
                        <li class="flex gap-3 leading-snug">
                            <x-ui.icon name="check-circle" class="mt-0.5 size-5 shrink-0 text-yellow" />
                            <span>{{ $benefit }}</span>
                        </li>
                    @endforeach
                </ul>
                <p class="mt-8 border-t border-white/15 pt-6 text-white/80">{{ __('pages/organiser.membership.how') }}</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <x-ui.button :href="'mailto:'.$settings->email" variant="highlight" icon-start="mail">{{ __('pages/organiser.membership.email_cta') }}</x-ui.button>
                    <x-ui.button :href="$shell->telUrl()" variant="on-dark" icon-start="phone">{{ __('pages/organiser.membership.call_cta') }}</x-ui.button>
                </div>
            </div>
        </div>
    </x-ui.section>

    <x-ui.section tone="cream" id="office">
        <div class="grid items-stretch gap-6 overflow-hidden rounded-[2rem] bg-white shadow-soft ring-1 ring-ink/5 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,0.8fr)] lg:gap-0">
            <div class="p-7 md:p-10">
                <p class="eyebrow">{{ __('pages/organiser.office.eyebrow') }}</p>
                <h2 class="mt-3 font-display text-display-sm font-semibold text-navy">{{ __('pages/organiser.office.title') }}</h2>
                <p class="mt-4 flex gap-2.5 text-lead text-ink">
                    <x-ui.icon name="map-pin" class="mt-1.5 size-5 shrink-0 text-green" />
                    <span>{{ $settings->office_address }}</span>
                </p>

                <dl class="mt-8 grid gap-5 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold tracking-wide text-ink-soft uppercase">{{ __('pages/organiser.office.phone') }}</dt>
                        <dd class="mt-1"><a href="{{ $shell->telUrl() }}" class="link-underline font-semibold text-navy">{{ $settings->phone }}</a></dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold tracking-wide text-ink-soft uppercase">{{ __('pages/organiser.office.email') }}</dt>
                        <dd class="mt-1"><a href="mailto:{{ $settings->email }}" class="link-underline font-semibold break-all text-navy">{{ $settings->email }}</a></dd>
                    </div>
                </dl>

                <div class="mt-8 flex flex-wrap gap-3">
                    <x-ui.button :href="$mapUrl" variant="secondary" icon-start="navigation" target="_blank" rel="noopener">{{ __('pages/organiser.office.map') }}</x-ui.button>
                    <x-ui.button :href="$shell->whatsappUrl()" variant="ghost" icon-start="whatsapp" target="_blank" rel="noopener">{{ __('pages/organiser.office.whatsapp') }}</x-ui.button>
                </div>
            </div>

            <div x-data="clock('Asia/Dhaka')" data-tone="midnight" class="relative isolate flex flex-col justify-between gap-8 overflow-hidden bg-midnight p-7 text-white md:p-10">
                <x-ui.motif variant="tiles" :size="72" class="absolute inset-0 -z-10 opacity-30 [mask-image:linear-gradient(to_top,black,transparent)]" />
                <p class="text-sm font-semibold text-white/60">{{ __('pages/organiser.office.local_time') }}</p>
                <p class="font-display text-display-xl leading-none font-semibold tabular" x-text="time">{{ $formatter->time(now(), 'Asia/Dhaka') }}</p>
                <p class="text-sm text-white/60">{{ __('pages/organiser.office.hours_note') }}</p>
            </div>
        </div>
    </x-ui.section>
</x-layouts.site>
