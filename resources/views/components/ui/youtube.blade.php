@props([
    'id',
    'title',
    'poster' => null,
    'caption' => null,
])

{{-- A click-to-load YouTube facade: our own poster image until the visitor presses play, then youtube-nocookie. --}}
<figure {{ $attributes->class(['group']) }}>
    <div x-data="youtubeFacade(@js($id), @js($title))" class="relative aspect-video overflow-hidden rounded-2xl bg-midnight shadow-soft">
        <div x-ref="player" class="absolute inset-0">
            @if ($poster)
                <x-ui.img :key="$poster" alt="" sizes="(min-width: 1024px) 30vw, 90vw" class="size-full object-cover transition duration-500 group-hover:scale-[1.03]" />
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-midnight/80 via-midnight/20 to-transparent"></div>
            <button
                type="button"
                x-on:click="play()"
                data-youtube-id="{{ $id }}"
                class="absolute inset-0 flex items-end p-4 text-left text-white"
            >
                {{-- Centred on wide cards; on phones the card is short, so the button moves to the corner, clear of the title. --}}
                <span class="absolute top-1/2 left-1/2 grid size-14 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full bg-crimson text-white shadow-lift transition-transform duration-300 group-hover:scale-110 max-sm:top-4 max-sm:left-4 max-sm:size-11 max-sm:translate-x-0 max-sm:translate-y-0">
                    <x-ui.icon name="play" class="size-6 translate-x-0.5" />
                </span>
                <span class="relative">
                    <span class="block font-semibold leading-snug">{{ $title }}</span>
                    <span class="mt-0.5 flex items-center gap-1.5 text-xs text-white/70"><x-ui.icon name="youtube" class="size-3.5" /> {{ __('home.hero.video_note') }}</span>
                </span>
            </button>
        </div>
    </div>
    @if ($caption)
        <figcaption class="mt-2 text-sm text-ink-soft">{{ $caption }}</figcaption>
    @endif
</figure>
