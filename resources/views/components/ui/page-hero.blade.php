@props([
    'variant' => 'editorial',
    'eyebrow' => null,
    'title',
    'lead' => null,
    'image' => null,
    'imageAlt' => '',
    'focus' => 'center',
    'breadcrumbs' => null,
])

{{--
    Three hero types so page templates differ by purpose (spec §6), unlike a single photo hero on every page:
    editorial (light, type-led, optional framed photo), photo (full-bleed photograph) and dark (midnight with motif).
--}}
@if ($variant === 'photo')
    <section data-tone="midnight" {{ $attributes->class(['relative isolate flex min-h-[min(86svh,54rem)] items-end overflow-hidden bg-midnight text-white']) }}>
        @if ($image)
            <x-ui.img :key="$image" :alt="$imageAlt" eager sizes="100vw" class="absolute inset-0 -z-20 size-full object-cover" style="object-position: {{ $focus }}" />
        @endif
        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-midnight via-midnight/60 to-midnight/0" aria-hidden="true"></div>
        <div class="absolute inset-x-0 top-0 -z-10 h-40 bg-gradient-to-b from-midnight/50 to-transparent" aria-hidden="true"></div>

        <div class="container-site pt-40 pb-12 md:pb-16">
            @if ($breadcrumbs)
                <x-ui.breadcrumbs :items="$breadcrumbs" class="mb-6" />
            @endif
            <div class="max-w-4xl">
                @if ($eyebrow)
                    <p class="eyebrow !text-mint">{{ $eyebrow }}</p>
                @endif
                <h1 class="mt-3 font-display text-display-2xl font-semibold text-white">{{ $title }}</h1>
                @if ($lead)
                    <p class="mt-6 max-w-2xl text-lead text-white/85">{{ $lead }}</p>
                @endif
                @isset($actions)
                    <div class="mt-8 flex flex-wrap gap-3">{{ $actions }}</div>
                @endisset
            </div>
            @isset($facts)
                <div class="mt-10">{{ $facts }}</div>
            @endisset
        </div>
    </section>
@elseif ($variant === 'dark')
    <section data-tone="midnight" {{ $attributes->class(['relative isolate overflow-hidden bg-midnight pt-10 pb-16 text-white md:pt-14 md:pb-24']) }} style="--motif-1: #0c2444; --motif-2: #11305a; --motif-3: #1b5a55">
        <x-ui.motif variant="tiles" :size="88" class="absolute inset-y-0 right-0 -z-10 w-full opacity-60 md:w-2/3 [mask-image:linear-gradient(to_left,black_20%,transparent)]" />
        <div class="absolute -top-32 -left-32 -z-10 size-96 rounded-full bg-green/40 blur-3xl" aria-hidden="true"></div>

        <div class="container-site">
            @if ($breadcrumbs)
                <x-ui.breadcrumbs :items="$breadcrumbs" class="mb-10" />
            @endif
            <div class="max-w-3xl">
                @if ($eyebrow)
                    <p class="eyebrow !text-mint">{{ $eyebrow }}</p>
                @endif
                <h1 class="mt-3 font-display text-display-xl font-semibold text-white">{{ $title }}</h1>
                @if ($lead)
                    <p class="mt-6 text-lead text-white/80">{{ $lead }}</p>
                @endif
                @isset($actions)
                    <div class="mt-8 flex flex-wrap gap-3">{{ $actions }}</div>
                @endisset
            </div>
            @isset($facts)
                <div class="mt-12">{{ $facts }}</div>
            @endisset
        </div>
    </section>
@else
    <section data-tone="cream" {{ $attributes->class(['grain relative isolate overflow-hidden bg-cream pt-8 pb-14 md:pt-12 md:pb-20']) }}>
        <x-ui.motif variant="jamdani" class="absolute top-0 right-0 -z-10 h-full w-2/3 text-sand-2 opacity-60 [mask-image:radial-gradient(ellipse_at_top_right,black,transparent_70%)]" />

        <div class="container-site">
            @if ($breadcrumbs)
                <x-ui.breadcrumbs :items="$breadcrumbs" class="mb-8 md:mb-12" />
            @endif
            <div @class(['grid items-center gap-10 lg:gap-16', 'lg:grid-cols-[minmax(0,1.1fr)_minmax(0,0.9fr)]' => $image || isset($aside)])>
                <div>
                    @if ($eyebrow)
                        <p class="eyebrow">{{ $eyebrow }}</p>
                    @endif
                    <h1 class="mt-3 max-w-4xl font-display text-display-xl font-semibold text-navy">{{ $title }}</h1>
                    @if ($lead)
                        <p class="mt-6 max-w-2xl text-lead text-ink-soft">{{ $lead }}</p>
                    @endif
                    @isset($actions)
                        <div class="mt-8 flex flex-wrap gap-3">{{ $actions }}</div>
                    @endisset
                </div>

                @if ($image)
                    <div class="relative">
                        <div class="aspect-[4/3] overflow-hidden rounded-[2rem] shadow-lift ring-1 ring-ink/5 lg:aspect-[5/6]">
                            <x-ui.img :key="$image" :alt="$imageAlt" eager sizes="(min-width: 1024px) 40vw, 100vw" class="size-full object-cover" style="object-position: {{ $focus }}" />
                        </div>
                        <div class="absolute -bottom-5 -left-5 -z-10 hidden size-32 overflow-hidden rounded-3xl bg-yellow lg:block" style="--motif-1: #002776; --motif-2: #004f3a; --motif-3: #b3122a" aria-hidden="true">
                            <x-ui.motif variant="tiles" class="size-full opacity-25" />
                        </div>
                    </div>
                @elseif (isset($aside))
                    <div>{{ $aside }}</div>
                @endif
            </div>
            @isset($facts)
                <div class="mt-12">{{ $facts }}</div>
            @endisset
        </div>
    </section>
@endif
