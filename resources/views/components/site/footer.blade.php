@inject('shell', 'App\View\SiteShell')
@inject('localizedUrls', 'App\Support\Localization\LocalizedUrls')

@php
    $columns = collect($shell->navigation->footer());
    $legal = $columns->firstWhere('key', 'legal');
    $columns = $columns->reject(fn (array $group): bool => $group['key'] === 'legal')->values();
    $settings = $shell->settings;
@endphp

<footer data-tone="midnight" class="relative isolate overflow-hidden bg-midnight text-white">
    <x-ui.motif variant="band" class="block h-6 w-full text-midnight-3" style="--motif-bg: #071a33" />
    <div class="absolute -top-40 left-1/2 -z-10 h-80 w-[60rem] -translate-x-1/2 rounded-full bg-green/25 blur-3xl" aria-hidden="true"></div>

    <div class="container-site grid gap-12 py-14 lg:grid-cols-[minmax(0,1fr)_minmax(0,2fr)] lg:gap-16 lg:py-20">
        <div>
            <x-site.logo tone="dark" />
            <p class="mt-5 max-w-sm leading-relaxed text-white/70">{{ __('site.footer.mission') }}</p>

            <div class="mt-8 flex max-w-sm items-center gap-4 rounded-2xl bg-white/[0.04] p-4 ring-1 ring-white/10">
                <x-ui.img key="bbcci-mark" alt="" sizes="56px" class="size-14 rounded-xl object-cover" />
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-[0.14em] text-white/50">{{ __('site.footer.organised_by') }}</p>
                    <p class="mt-1 font-medium leading-snug">{{ $settings->organiser_name }}</p>
                </div>
            </div>
        </div>

        @if ($columns->isNotEmpty())
            <nav aria-label="{{ __('nav.footer') }}" class="grid grid-cols-2 gap-x-6 gap-y-10 sm:grid-cols-3 xl:grid-cols-5">
                @foreach ($columns as $group)
                    <div>
                        <h2 class="font-sans text-sm font-semibold text-yellow">{{ $group['label'] }}</h2>
                        <ul class="mt-4 space-y-2.5">
                            @foreach ($group['items'] as $item)
                                <li>
                                    <a href="{{ $item['url'] }}" class="text-[0.95rem] text-white/75 transition-colors hover:text-white">{{ $item['label'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </nav>
        @endif
    </div>

    <div class="container-site grid gap-10 border-t border-white/10 py-10 md:grid-cols-[minmax(0,1.4fr)_minmax(0,1fr)_minmax(0,1fr)]">
        <div>
            <h2 class="font-sans text-sm font-semibold text-yellow">{{ __('site.footer.contact_heading') }}</h2>
            <address class="mt-4 space-y-3 not-italic text-[0.95rem] text-white/75">
                <p class="flex items-start gap-3">
                    <x-ui.icon name="map-pin" class="mt-0.5 size-4 text-white/50" />
                    <span><span class="block text-white">{{ __('site.footer.office') }}</span>{{ $settings->office_address }}</span>
                </p>
                <p class="flex items-center gap-3">
                    <x-ui.icon name="phone" class="size-4 text-white/50" />
                    <a href="{{ $shell->telUrl() }}" class="tabular hover:text-white">{{ $settings->phone }}</a>
                </p>
                <p class="flex items-center gap-3">
                    <x-ui.icon name="whatsapp" class="size-4 text-white/50" />
                    <a href="{{ $shell->whatsappUrl() }}" target="_blank" rel="noopener" class="hover:text-white">{{ __('site.footer.whatsapp') }}</a>
                </p>
                <p class="flex items-center gap-3">
                    <x-ui.icon name="mail" class="size-4 text-white/50" />
                    <a href="mailto:{{ $settings->email }}" class="break-all hover:text-white">{{ $settings->email }}</a>
                </p>
            </address>
        </div>

        <div>
            <h2 class="font-sans text-sm font-semibold text-yellow">{{ __('site.footer.languages') }}</h2>
            <ul class="mt-4 space-y-2.5">
                @foreach ($localizedUrls->switcher() as $link)
                    <li>
                        <a href="{{ $link['url'] }}" lang="{{ $link['locale']->htmlLang }}" @class([
                            'text-[0.95rem] transition-colors hover:text-white',
                            'font-semibold text-white' => $link['isCurrent'],
                            'text-white/75' => ! $link['isCurrent'],
                        ])>{{ $link['locale']->nativeName }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div x-data="motionToggle">
            <h2 class="font-sans text-sm font-semibold text-yellow">{{ __('site.footer.preferences') }}</h2>
            <button
                type="button"
                role="switch"
                aria-checked="false"
                x-bind:aria-checked="reduced.toString()"
                x-on:click="toggle()"
                class="mt-4 inline-flex items-center gap-3 rounded-full py-1 pr-2 text-[0.95rem] text-white/75 hover:text-white"
            >
                <span class="relative h-6 w-11 rounded-full bg-white/15 ring-1 ring-white/20 transition-colors" x-bind:class="reduced && '!bg-mint'" aria-hidden="true">
                    <span class="absolute top-1 left-1 size-4 rounded-full bg-white shadow transition-transform duration-200" x-bind:class="reduced && 'translate-x-5'"></span>
                </span>
                <span>{{ __('site.motion.reduce') }}</span>
            </button>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="container-site flex flex-col gap-4 pt-6 pb-28 text-sm text-white/55 md:flex-row md:items-center md:justify-between">
            <p>{{ __('site.footer.copyright', ['year' => $shell->year(), 'organiser' => $settings->organiser_name]) }}</p>
            @if ($legal)
                <ul class="flex flex-wrap gap-x-5 gap-y-2">
                    @foreach ($legal['items'] as $item)
                        <li><a href="{{ $item['url'] }}" class="transition-colors hover:text-white">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</footer>
