@inject('images', 'App\Support\Images\ImageManifest')
@inject('formatter', 'App\Support\Localization\LocaleFormatter')

@php
    $breadcrumbs = [
        ['label' => __('site.home'), 'url' => localized_route('home')],
        ['label' => __('nav.items.gallery.label'), 'url' => localized_route('gallery')],
        ['label' => $album->title],
    ];

    $total = $album->photos->count();

    $lightboxPhotos = $album->photos->map(function ($photo) use ($images): array {
        $entry = $images->get($photo->image);

        return [
            'src' => $images->url($photo->image, 1600, 'jpg'),
            'srcset' => collect($entry['widths'] ?? [])->map(fn (int $width): string => asset("img/{$photo->image}-{$width}.webp")." {$width}w")->implode(', '),
            'width' => $entry['w'] ?? null,
            'height' => $entry['h'] ?? null,
            'caption' => $photo->caption,
        ];
    })->values()->all();
@endphp

<x-layouts.site :title="$album->title.' · '.__('pages/gallery.meta_title').' · '.__('site.brand')" :description="$album->description" :image="$album->cover">
    @push('head')
        <x-seo.json-ld :data="$structuredData" />
    @endpush

    <x-ui.page-hero variant="dark" :eyebrow="__('pages/gallery.eyebrow')" :title="$album->title" :lead="$album->description" :breadcrumbs="$breadcrumbs" />

    <x-ui.section tone="cream">
        <div x-data="lightbox(@js($lightboxPhotos), @js(__('pages/gallery.lightbox.counter')))">
            <ul class="columns-1 gap-4 sm:columns-2 lg:columns-3">
                @foreach ($album->photos as $photo)
                    <li class="mb-4 break-inside-avoid">
                        <figure>
                            <button
                                type="button"
                                data-lightbox-item="{{ $loop->index }}"
                                x-on:click="open({{ $loop->index }}, $event)"
                                aria-label="{{ __('pages/gallery.open', ['number' => $formatter->plain($loop->iteration), 'total' => $formatter->plain($total), 'caption' => $photo->caption]) }}"
                                class="group block w-full overflow-hidden rounded-[1.25rem] bg-cream-2 focus-visible:outline-offset-4"
                            >
                                <x-ui.img :key="$photo->image" :alt="$photo->caption" sizes="(min-width: 1024px) 30vw, (min-width: 640px) 45vw, 100vw" class="w-full transition duration-700 group-hover:scale-[1.03]" />
                            </button>
                            <figcaption class="mt-2 px-1 text-sm leading-snug text-ink-soft">{{ $photo->caption }}</figcaption>
                        </figure>
                    </li>
                @endforeach
            </ul>

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

                    <figure class="flex min-h-0 flex-1 flex-col items-center justify-center gap-4 px-4 pb-6 md:px-20">
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
        </div>

        <p class="mt-10 text-center">
            <x-ui.link :href="localized_route('gallery')">{{ __('pages/gallery.back') }}</x-ui.link>
        </p>
    </x-ui.section>
</x-layouts.site>
