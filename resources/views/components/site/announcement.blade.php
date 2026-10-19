@inject('shell', 'App\View\SiteShell')

@if ($edition = $shell->edition())
    <div
        x-data="announcement(@js('mbe.announcement.'.$edition->slug))"
        x-show="visible"
        data-announcement
        data-tone="midnight"
        role="region"
        aria-label="{{ __('site.announcement.label') }}"
        class="relative z-30 bg-midnight text-white"
    >
        <div class="container-site flex min-h-11 items-center gap-3 py-2 text-[0.8125rem] sm:text-sm">
            <span class="size-2 shrink-0 rounded-full bg-mint animate-pulse-dot" aria-hidden="true"></span>
            <p class="min-w-0 flex-1 leading-snug">
                <strong class="hidden font-semibold sm:inline">{{ $edition->name }}</strong>
                <span class="mx-1.5 hidden text-white/40 sm:inline" aria-hidden="true">·</span>
                <span class="tabular">{{ $shell->dateRange() }}</span>
                @if ($venue = $shell->venueLine())
                    <span class="hidden md:inline"><span class="mx-1.5 text-white/40" aria-hidden="true">·</span>{{ $venue }}</span>
                @endif
            </p>
            @if ($shell->navigation->has('register'))
                <a href="{{ localized_route('register') }}" class="inline-flex shrink-0 items-center gap-1 rounded-full font-semibold text-yellow underline-offset-4 hover:underline">
                    {{ __('site.announcement.register') }}
                    <x-ui.icon name="arrow-right" class="size-4" />
                </a>
            @endif
            <button
                type="button"
                x-on:click="dismiss()"
                class="-mr-2 grid size-9 shrink-0 place-items-center rounded-full text-white/70 transition hover:bg-white/10 hover:text-white"
                aria-label="{{ __('site.announcement.dismiss') }}"
            >
                <x-ui.icon name="x" class="size-4" />
            </button>
        </div>
    </div>
@endif
