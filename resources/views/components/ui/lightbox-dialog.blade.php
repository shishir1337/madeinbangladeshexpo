{{-- The full-screen viewer for an x-data="lightbox(...)" parent: counter, photo, caption, previous/next and close. --}}
<dialog
    x-ref="dialog"
    aria-label="{{ __('pages/gallery.lightbox.label') }}"
    x-on:close="closed()"
    x-on:keydown.left.prevent="step(-1)"
    x-on:keydown.right.prevent="step(1)"
    x-on:touchstart.passive="touchStart($event)"
    x-on:touchend="touchEnd($event)"
    x-on:click.self="close()"
    class="m-0 size-full max-h-none max-w-none bg-midnight/95 p-0 text-white backdrop:bg-midnight/80"
>
    <div class="flex size-full flex-col">
        <div class="flex items-center justify-between gap-4 p-4 md:p-6">
            <p class="text-sm font-semibold text-white/75 tabular" aria-live="polite" x-text="counter"></p>
            <button type="button" x-on:click="close()" class="grid size-11 place-items-center rounded-full bg-white/10 ring-1 ring-white/20 transition hover:bg-white/20" aria-label="{{ __('pages/gallery.lightbox.close') }}">
                <x-ui.icon name="x" class="size-5" />
            </button>
        </div>

        <figure class="flex min-h-0 flex-1 flex-col items-center justify-center gap-4 px-4 pb-20 md:px-20 md:pb-6">
            <template x-if="current">
                <img x-bind:src="current.src" x-bind:srcset="current.srcset" sizes="100vw" x-bind:alt="current.caption" x-bind:width="current.width" x-bind:height="current.height" class="max-h-[75svh] w-auto max-w-full rounded-xl object-contain shadow-lift">
            </template>
            <figcaption class="max-w-2xl text-center leading-relaxed text-white/85" x-text="current?.caption"></figcaption>
        </figure>

        <button type="button" x-on:click="step(-1)" class="absolute top-1/2 left-3 grid size-12 -translate-y-1/2 place-items-center rounded-full bg-white/10 ring-1 ring-white/20 transition hover:bg-white/20 max-md:top-auto max-md:bottom-4 max-md:translate-y-0 md:left-6" aria-label="{{ __('pages/gallery.lightbox.previous') }}">
            <x-ui.icon name="arrow-left" class="size-5" />
        </button>
        <button type="button" x-on:click="step(1)" class="absolute top-1/2 right-3 grid size-12 -translate-y-1/2 place-items-center rounded-full bg-white/10 ring-1 ring-white/20 transition hover:bg-white/20 max-md:top-auto max-md:bottom-4 max-md:translate-y-0 md:right-6" aria-label="{{ __('pages/gallery.lightbox.next') }}">
            <x-ui.icon name="arrow-right" class="size-5" />
        </button>
    </div>
</dialog>
