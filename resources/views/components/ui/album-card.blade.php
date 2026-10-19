@props([
    'album',
])

@inject('formatter', 'App\Support\Localization\LocaleFormatter')

{{-- An album: cover photo, title, description and photo count, linking to the album page. --}}
<a href="{{ localized_route('gallery.show', ['album' => $album]) }}" {{ $attributes->class(['group block overflow-hidden rounded-[1.75rem] bg-white shadow-soft ring-1 ring-ink/5 transition duration-300 hover:-translate-y-1 hover:shadow-lift']) }}>
    <div class="relative aspect-[16/10] overflow-hidden bg-cream-2">
        <x-ui.img :key="$album->cover" alt="" sizes="(min-width: 1024px) 40vw, 100vw" class="size-full object-cover transition duration-700 group-hover:scale-[1.04]" />
        <span class="absolute right-4 bottom-4 inline-flex items-center gap-1.5 rounded-full bg-midnight/80 px-3 py-1 text-xs font-semibold text-white backdrop-blur">
            <x-ui.icon name="camera" class="size-3.5" />
            {{ trans_choice('pages/archive.albums.photos', $album->photos_count ?? $album->photos->count(), ['count' => $formatter->number($album->photos_count ?? $album->photos->count())]) }}
        </span>
    </div>
    <div class="p-6 md:p-7">
        <h3 class="font-display text-xl font-semibold text-navy">{{ $album->title }}</h3>
        @if ($album->description)
            <p class="mt-2 leading-relaxed text-ink-soft">{{ $album->description }}</p>
        @endif
    </div>
</a>
