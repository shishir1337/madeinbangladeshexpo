@inject('shell', 'App\View\SiteShell')
@inject('localizedUrls', 'App\Support\Localization\LocalizedUrls')

@php
    $groups = collect($shell->navigation->footer())->keyBy('key');
    $legal = $groups->get('legal');
    $settings = $shell->settings;

    // Four columns of about the same length; the last one is for help: the help pages, then how to reach a person.
    $columns = collect([['the-expo'], ['take-part'], ['plan-your-trip', 'news-media'], ['help']])
        ->map(fn (array $keys): array => collect($keys)->map(fn (string $key): ?array => $groups->get($key))->filter()->values()->all())
        ->filter(fn (array $column, int $index): bool => $column !== [] || $index === 3)
        ->values();

    $emailUser = \Illuminate\Support\Str::before($settings->email, '@');
    $emailDomain = \Illuminate\Support\Str::after($settings->email, '@');
    $websiteHost = preg_replace('/^www\./', '', (string) parse_url($settings->website, PHP_URL_HOST));
@endphp

<footer data-tone="midnight" data-hides-help="0" class="relative isolate overflow-hidden bg-midnight text-white">
    <x-ui.motif variant="band" class="block h-6 w-full text-midnight-3" style="--motif-bg: #071a33" />
    <div class="absolute inset-x-0 top-0 -z-10 h-[32rem] bg-[radial-gradient(50%_60%_at_50%_0%,rgb(0_79_58/0.32),transparent_70%)]" aria-hidden="true"></div>

    <div class="container-site grid gap-x-12 gap-y-12 pt-14 pb-12 lg:pt-20 xl:grid-cols-[minmax(0,1fr)_minmax(0,3fr)]">
        {{-- Who we are and what is next. Beside the links at xl; above them, in two halves, at lg. --}}
        <div class="grid content-start gap-8 lg:max-xl:grid-cols-2 lg:max-xl:gap-12">
            <div>
                <x-site.logo tone="dark" />
                <p class="mt-5 max-w-sm leading-relaxed text-white/70">{{ __('site.footer.mission') }}</p>
            </div>

            <div class="grid content-start gap-4">
                @if ($shell->dateRange())
                    <div class="rounded-2xl bg-white/[0.04] p-4 ring-1 ring-white/10">
                        <p class="flex items-center gap-2 text-xs font-semibold tracking-[0.14em] text-mint uppercase">
                            <span class="size-1.5 rounded-full bg-mint" aria-hidden="true"></span>
                            {{ __('site.footer.this_edition') }}
                        </p>
                        <p class="mt-3 flex items-start gap-2.5 text-[0.95rem] font-medium">
                            <x-ui.icon name="calendar" class="mt-0.5 size-4 text-yellow" />
                            <span class="tabular">{{ $shell->dateRange() }}</span>
                        </p>
                        @if ($shell->venueLine())
                            <p class="mt-2 flex items-start gap-2.5 text-[0.95rem] text-white/75">
                                <x-ui.icon name="map-pin" class="mt-0.5 size-4 text-yellow" />
                                <span>{{ $shell->venueLine() }}</span>
                            </p>
                        @endif
                    </div>
                @endif

                <a href="{{ $settings->website }}" target="_blank" rel="noopener" class="group flex items-center gap-4 rounded-2xl bg-white/[0.04] p-4 ring-1 ring-white/10 transition hover:bg-white/[0.07]">
                    <span class="shrink-0"><x-ui.img key="bbcci-mark" alt="" sizes="48px" class="size-12 rounded-xl object-cover" /></span>
                    <span class="min-w-0">
                        <span class="block text-xs font-semibold tracking-[0.14em] text-white/50 uppercase">{{ __('site.footer.organised_by') }}</span>
                        <span class="mt-1 block leading-snug font-medium">{{ $settings->organiser_name }}</span>
                        <span class="mt-1 inline-flex items-center gap-1 text-sm text-white/55 transition-colors group-hover:text-white">
                            {{ $websiteHost }}
                            <x-ui.icon name="arrow-up-right" class="size-3.5" />
                        </span>
                    </span>
                </a>
            </div>
        </div>

        <nav aria-label="{{ __('nav.footer') }}" class="grid gap-x-8 gap-y-10 max-sm:gap-y-0 sm:grid-cols-2 lg:grid-cols-[repeat(3,minmax(0,1fr))_minmax(0,1.5fr)]">
            @foreach ($columns as $column)
                <div data-footer-column class="grid content-start gap-10 max-sm:gap-0">
                    @foreach ($column as $group)
                        {{-- On phones each group folds away behind its heading; from sm up every list is open. --}}
                        <div x-data="{ open: false }" class="max-sm:border-b max-sm:border-white/10">
                            <h2 class="font-sans text-sm font-semibold text-yellow">
                                <span class="max-sm:hidden">{{ $group['label'] }}</span>
                                <button
                                    type="button"
                                    x-on:click="open = ! open"
                                    aria-expanded="true"
                                    x-bind:aria-expanded="open.toString()"
                                    aria-controls="footer-{{ $group['key'] }}"
                                    class="flex min-h-12 w-full items-center justify-between gap-4 text-left sm:hidden"
                                >
                                    {{ $group['label'] }}
                                    <x-ui.icon name="plus" class="size-4 text-white/60 transition-transform duration-300" x-bind:class="open && 'rotate-45'" />
                                </button>
                            </h2>
                            {{-- Tight leading inside a link, more space between links: a label that wraps still reads as one link. --}}
                            <ul id="footer-{{ $group['key'] }}" class="space-y-3 max-sm:pb-5 sm:mt-4" x-bind:class="open ? '' : 'max-sm:hidden'">
                                @foreach ($group['items'] as $item)
                                    <li>
                                        <a href="{{ $item['url'] }}" class="inline-block text-[0.95rem] leading-snug text-white/75 transition-colors hover:text-white">{{ $item['label'] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach

                    @if ($loop->last)
                        <div class="max-sm:mt-10">
                            <h2 class="font-sans text-sm font-semibold text-yellow">{{ __('site.footer.contact_heading') }}</h2>
                            <address class="mt-4 space-y-3 text-[0.95rem] text-white/75 not-italic">
                                <p class="flex items-start gap-3">
                                    <x-ui.icon name="map-pin" class="mt-0.5 size-4 text-white/50" />
                                    <span><span class="block text-white">{{ __('site.footer.office') }}</span>{{ $settings->office_address }}</span>
                                </p>
                                <p class="flex items-center gap-3">
                                    <x-ui.icon name="phone" class="size-4 text-white/50" />
                                    <a href="{{ $shell->telUrl() }}" class="tabular transition-colors hover:text-white">{{ $settings->phone }}</a>
                                </p>
                                <p class="flex items-center gap-3">
                                    <x-ui.icon name="whatsapp" class="size-4 text-white/50" />
                                    <a href="{{ $shell->whatsappUrl() }}" target="_blank" rel="noopener" class="transition-colors hover:text-white">{{ __('site.footer.whatsapp') }}</a>
                                </p>
                                <p class="flex items-start gap-3">
                                    <x-ui.icon name="mail" class="mt-1 size-4 text-white/50" />
                                    {{-- The address may wrap only after the @, never in the middle of the domain. --}}
                                    <a href="mailto:{{ $settings->email }}" class="min-w-0 transition-colors hover:text-white">{{ $emailUser }}@<wbr>{{ $emailDomain }}</a>
                                </p>
                            </address>
                        </div>
                    @endif
                </div>
            @endforeach
        </nav>
    </div>

    {{-- The sign-off: the expo's mark and name at full width. --}}
    <div class="container-site flex items-end gap-[3vw] overflow-hidden pb-8" aria-hidden="true">
        <svg class="mb-[1.2vw] w-[clamp(3.5rem,11vw,9.5rem)] shrink-0" viewBox="0 0 40 30" focusable="false">
            <circle cx="15" cy="15" r="11" fill="#e8283f" />
            <circle cx="25" cy="15" r="11" fill="#2456d6" />
            <path d="M20 5.4a11 11 0 0 1 0 19.2 11 11 0 0 1 0-19.2Z" fill="#004f3a" />
            <path d="M20 11.2 23.8 15 20 18.8 16.2 15Z" fill="#ffdf00" />
        </svg>
        <p class="min-w-0 font-display text-[clamp(2.6rem,8.6vw,8.25rem)] leading-[0.86] font-bold tracking-[-0.045em] text-balance text-white/[0.09]">{{ __('site.brand') }}</p>
    </div>

    {{-- Legal on the left; language and motion, the two settings a visitor can change, on the right. --}}
    <div class="container-site">
        <div class="flex flex-col gap-6 border-t border-white/10 pt-6 pb-8 text-sm text-white/55 no-js:pb-28 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-col gap-3 md:flex-row md:flex-wrap md:items-center md:gap-x-6">
                <p>{{ __('site.footer.copyright', ['year' => $shell->year(), 'organiser' => $settings->organiser_name]) }}</p>
                @if ($legal)
                    <ul class="flex flex-wrap gap-x-5 gap-y-2">
                        @foreach ($legal['items'] as $item)
                            <li><a href="{{ $item['url'] }}" class="transition-colors hover:text-white">{{ $item['label'] }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="flex flex-wrap items-center gap-x-6 gap-y-4 lg:shrink-0 lg:flex-nowrap">
                <ul class="flex items-center gap-1 rounded-full bg-white/[0.05] p-1 ring-1 ring-white/10" aria-label="{{ __('site.footer.languages') }}">
                    @foreach ($localizedUrls->switcher() as $link)
                        <li>
                            <a
                                href="{{ $link['url'] }}"
                                lang="{{ $link['locale']->htmlLang }}"
                                hreflang="{{ $link['locale']->htmlLang }}"
                                @if ($link['isCurrent']) aria-current="page" @endif
                                @class([
                                    'inline-flex h-8 items-center rounded-full px-3.5 transition-colors',
                                    'bg-white font-semibold text-navy' => $link['isCurrent'],
                                    'text-white/75 hover:text-white' => ! $link['isCurrent'],
                                ])
                            >{{ $link['locale']->nativeName }}</a>
                        </li>
                    @endforeach
                </ul>

                <button
                    x-data="motionToggle"
                    type="button"
                    role="switch"
                    aria-checked="false"
                    x-bind:aria-checked="reduced.toString()"
                    x-on:click="toggle()"
                    class="inline-flex items-center gap-3 rounded-full py-1 text-white/75 transition-colors hover:text-white"
                >
                    <span class="relative h-6 w-11 rounded-full bg-white/15 ring-1 ring-white/20 transition-colors" x-bind:class="reduced && '!bg-mint'" aria-hidden="true">
                        <span class="absolute top-1 left-1 size-4 rounded-full bg-white shadow transition-transform duration-200" x-bind:class="reduced && 'translate-x-5'"></span>
                    </span>
                    <span>{{ __('site.motion.reduce') }}</span>
                </button>
            </div>
        </div>
    </div>
</footer>
