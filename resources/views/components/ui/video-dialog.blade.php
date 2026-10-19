@props([
    'youtubeId',
    'title',
])

{{-- Nothing loads from YouTube until the visitor presses play: the iframe is created on click (privacy and LCP). --}}
<div x-data="videoDialog(@js($youtubeId))" {{ $attributes }}>
    <button
        type="button"
        x-on:click="open()"
        data-youtube-id="{{ $youtubeId }}"
        class="group inline-flex items-center gap-3 rounded-full bg-white/95 py-2 pr-5 pl-2 text-left text-sm font-semibold text-navy shadow-lift backdrop-blur transition hover:bg-white"
    >
        <span class="grid size-10 place-items-center rounded-full bg-crimson text-white transition-transform duration-300 group-hover:scale-110">
            <x-ui.icon name="play" class="size-4 translate-x-px" />
        </span>
        <span class="flex flex-col leading-tight">
            <span>{{ $slot }}</span>
            <span class="text-xs font-medium text-ink-soft">{{ __('home.hero.video_note') }}</span>
        </span>
    </button>

    <dialog
        x-ref="dialog"
        x-on:close="stop()"
        x-on:click.self="$refs.dialog.close()"
        aria-label="{{ $title }}"
        class="m-auto w-[min(94vw,64rem)] overflow-visible bg-transparent p-0 backdrop:bg-midnight/85 backdrop:backdrop-blur-sm"
    >
        <div class="relative">
            <button
                type="button"
                x-on:click="$refs.dialog.close()"
                class="absolute -top-12 right-0 inline-flex items-center gap-2 rounded-full px-3 py-2 text-sm font-semibold text-white hover:bg-white/10"
            >
                <x-ui.icon name="x" class="size-5" /> {{ __('home.hero.close_video') }}
            </button>
            <div x-ref="frame" class="aspect-video w-full overflow-hidden rounded-2xl bg-black shadow-lift"></div>
        </div>
    </dialog>
</div>
