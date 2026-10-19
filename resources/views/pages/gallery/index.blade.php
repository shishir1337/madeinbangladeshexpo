@php
    $breadcrumbs = [
        ['label' => __('site.home'), 'url' => localized_route('home')],
        ['label' => __('nav.items.gallery.label')],
    ];
@endphp

<x-layouts.site :title="__('pages/gallery.meta_title').' · '.__('site.brand')" :description="__('pages/gallery.meta_description')" image="expo25-guests">
    <x-ui.page-hero variant="dark" :eyebrow="__('pages/gallery.eyebrow')" :title="__('pages/gallery.title')" :lead="__('pages/gallery.lead')" :breadcrumbs="$breadcrumbs" />

    <x-ui.section tone="cream">
        <div class="grid gap-5 md:grid-cols-2">
            @foreach ($albums as $album)
                <x-ui.album-card :album="$album" data-reveal data-reveal-delay="{{ $loop->index * 0.06 }}" />
            @endforeach
        </div>
    </x-ui.section>
</x-layouts.site>
