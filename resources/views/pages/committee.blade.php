@inject('shell', 'App\View\SiteShell')
@inject('settings', 'App\Settings\GeneralSettings')

@use('App\Enums\PersonGroup')

@php
    $breadcrumbs = [
        ['label' => __('site.home'), 'url' => localized_route('home')],
        ['label' => __('nav.items.organiser.label'), 'url' => localized_route('organiser')],
        ['label' => __('nav.items.committee.label')],
    ];
@endphp

<x-layouts.site :title="__('pages/committee.meta_title').' · '.__('site.brand')" :description="__('pages/committee.meta_description')" image="expo25-guests">
    <x-ui.page-hero
        :eyebrow="__('pages/committee.eyebrow')"
        :title="__('pages/committee.title')"
        :lead="__('pages/committee.lead')"
        :breadcrumbs="$breadcrumbs"
    />

    @if ($patrons->isNotEmpty())
        <x-ui.section tone="white" id="patron" spacing="sm">
            <div class="grid items-center gap-8 lg:grid-cols-[minmax(0,0.8fr)_minmax(0,1.2fr)] lg:gap-16">
                <x-ui.heading :eyebrow="PersonGroup::Patron->label()" :title="__('pages/committee.patron_title')" :lead="__('pages/committee.patron_lead')" size="sm" />
                <div class="grid gap-5">
                    @foreach ($patrons as $person)
                        <x-ui.person :person="$person" featured />
                    @endforeach
                </div>
            </div>
        </x-ui.section>
    @endif

    @if ($leaders->isNotEmpty())
        <x-ui.section tone="cream" id="leadership">
            <x-ui.heading :eyebrow="PersonGroup::Leadership->label()" :title="__('pages/organiser.leaders.title')" :lead="__('pages/committee.leadership_lead')" />

            <div class="mt-12 grid gap-5 md:grid-cols-3">
                @foreach ($leaders as $person)
                    <x-ui.person :person="$person" data-reveal data-reveal-delay="{{ $loop->index * 0.06 }}" />
                @endforeach
            </div>
        </x-ui.section>
    @endif

    <x-ui.section tone="white" id="board">
        <x-ui.heading :eyebrow="__('pages/organiser.governance.title')" :title="PersonGroup::Board->label()" :lead="__('pages/committee.board.lead')" />

        @if ($board->isNotEmpty())
            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($board as $person)
                    <x-ui.person :person="$person" />
                @endforeach
            </div>
        @else
            <x-ui.notice class="mt-10 max-w-3xl" :title="__('pages/committee.board.pending_title')">
                {{ __('pages/committee.board.pending_body') }}
            </x-ui.notice>
        @endif

        <div class="mt-14 flex flex-col gap-6 rounded-[2rem] bg-cream p-7 ring-1 ring-sand md:flex-row md:items-center md:justify-between md:p-9">
            <div>
                <h2 class="font-display text-display-sm font-semibold text-navy">{{ __('pages/committee.contact.title') }}</h2>
                <p class="mt-2 text-ink-soft">{{ __('pages/committee.contact.body') }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <x-ui.button :href="'mailto:'.$settings->email" icon-start="mail">{{ __('pages/organiser.membership.email_cta') }}</x-ui.button>
                <x-ui.button :href="$shell->telUrl()" variant="secondary" icon-start="phone">{{ $settings->phone }}</x-ui.button>
            </div>
        </div>
    </x-ui.section>
</x-layouts.site>
