@inject('images', 'App\Support\Images\ImageManifest')
@inject('formatter', 'App\Support\Localization\LocaleFormatter')

@php
    $breadcrumbs = [
        ['label' => __('site.home'), 'url' => localized_route('home')],
        ['label' => __('nav.items.gallery.label'), 'url' => localized_route('gallery')],
        ['label' => $album->title],
    ];

    $total = $album->photos->count();

    $lightboxPhotos = $album->photos->map(fn ($photo): array => $images->lightboxPhoto($photo->image, $photo->caption))->values()->all();
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

            <x-ui.lightbox-dialog />
        </div>

        <p class="mt-10 text-center">
            <x-ui.link :href="localized_route('gallery')">{{ __('pages/gallery.back') }}</x-ui.link>
        </p>
    </x-ui.section>
</x-layouts.site>
