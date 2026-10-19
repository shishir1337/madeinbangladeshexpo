@inject('shell', 'App\View\SiteShell')
@use('App\Support\Navigation\SiteNavigation')

@php
    $label = __("nav.items.{$page}.label");
    $description = __("nav.items.{$page}.description");
    $features = __("pages/in-preparation.pages.{$page}");
    $features = is_array($features) ? $features : [];

    $breadcrumbs = [
        ['label' => __('site.home'), 'url' => localized_route('home')],
        ['label' => $label],
    ];
@endphp

<x-layouts.site :title="$label.' · '.__('site.brand')" :description="$description">
    @push('head')
        <meta name="robots" content="noindex, follow">
    @endpush

    <x-ui.page-hero variant="dark" :eyebrow="$group['label'] ?? __('site.brand')" :title="$label" :lead="$description" :breadcrumbs="$breadcrumbs">
        <x-slot:actions>
            <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-2 text-sm font-semibold text-white ring-1 ring-white/20">
                <span class="size-2 rounded-full bg-yellow animate-pulse-dot" aria-hidden="true"></span>
                {{ $shell->edition() ? __('pages/in-preparation.status_for', ['edition' => $shell->edition()->name]) : __('pages/in-preparation.status') }}
            </span>
        </x-slot:actions>
    </x-ui.page-hero>

    <x-ui.section tone="white">
        <div class="grid grid-cols-[minmax(0,1fr)] gap-8 lg:grid-cols-[minmax(0,1.15fr)_minmax(0,0.85fr)] lg:gap-12">
            <div>
                <p class="eyebrow">{{ __('pages/in-preparation.features_eyebrow') }}</p>
                <h2 class="mt-3 font-display text-display-sm font-semibold text-navy">{{ __('pages/in-preparation.features_title', ['page' => $label]) }}</h2>

                @if ($features !== [])
                    <ul class="mt-8 space-y-4">
                        @foreach ($features as $feature)
                            <li class="flex gap-4 rounded-2xl bg-cream p-5 ring-1 ring-sand" data-reveal data-reveal-delay="{{ $loop->index * 0.06 }}">
                                <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-green text-white">
                                    <x-ui.icon name="check" class="size-4" />
                                </span>
                                <span class="pt-1 leading-relaxed text-ink">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <p class="mt-8 flex gap-2.5 text-sm leading-relaxed text-ink-soft">
                    <x-ui.icon name="info" class="mt-0.5 size-4 shrink-0 text-green" />
                    <span>{{ __('pages/in-preparation.note') }}</span>
                </p>
            </div>

            <aside class="space-y-5">
                <div class="rounded-[1.75rem] bg-green p-7 text-white md:p-8" data-tone="green" id="updates">
                    <h2 class="font-display text-xl font-semibold text-white">{{ __('pages/in-preparation.notify_title') }}</h2>
                    <p class="mt-2 text-white/80">{{ __('pages/in-preparation.notify_lead') }}</p>
                    <div class="mt-6 rounded-[1.25rem] bg-white p-5 text-ink" data-tone="white">
                        <livewire:newsletter-signup />
                    </div>
                </div>

                <div class="rounded-[1.75rem] bg-cream p-7 ring-1 ring-sand">
                    <h2 class="font-display text-lg font-semibold text-navy">{{ __('pages/in-preparation.help_title') }}</h2>
                    <p class="mt-2 text-ink-soft">{{ __('pages/in-preparation.help_lead') }}</p>
                    <div class="mt-5 flex flex-wrap gap-3">
                        <x-ui.button :href="$shell->whatsappUrl()" icon-start="whatsapp" size="sm" target="_blank" rel="noopener">{{ __('site.footer.whatsapp') }}</x-ui.button>
                        <x-ui.button :href="$shell->telUrl()" variant="secondary" icon-start="phone" size="sm">{{ $shell->settings->phone }}</x-ui.button>
                    </div>
                </div>
            </aside>
        </div>
    </x-ui.section>

    @if ($related->isNotEmpty())
        <x-ui.section tone="cream">
            <x-ui.heading :eyebrow="$group['label']" :title="__('pages/in-preparation.related_title')" size="sm" />

            <ul class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($related as $item)
                    <li>
                        <a href="{{ $item['url'] }}" class="group flex h-full items-start gap-4 rounded-[1.5rem] bg-white p-5 shadow-soft ring-1 ring-ink/5 transition hover:-translate-y-0.5 hover:shadow-lift">
                            <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-green-50 text-green transition-colors group-hover:bg-green group-hover:text-white">
                                <x-ui.icon :name="$item['icon']" class="size-5" />
                            </span>
                            <span class="min-w-0">
                                <span class="flex flex-wrap items-center gap-2 font-semibold text-navy">
                                    {{ $item['label'] }}
                                    @unless (SiteNavigation::isInPreparation($item['route']))
                                        <x-ui.chip tone="green">{{ __('pages/in-preparation.live') }}</x-ui.chip>
                                    @endunless
                                </span>
                                <span class="mt-1 block text-sm leading-snug text-ink-soft">{{ $item['description'] }}</span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <p class="mt-10">
                <x-ui.link :href="localized_route('home')" icon="arrow-right">{{ __('pages/in-preparation.home') }}</x-ui.link>
            </p>
        </x-ui.section>
    @endif
</x-layouts.site>
