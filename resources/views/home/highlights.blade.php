@inject('navigation', 'App\Support\Navigation\SiteNavigation')
@inject('images', 'App\Support\Images\ImageManifest')

@php
    $photos = ['expo25-welcome', 'expo25-stand-accessories', 'expo25-speaker-shahriar-ahmed', 'expo25-stand-sts', 'expo25-guests', 'expo25-speaker-saiful-alam'];
    $videos = $page->videos();
    $testimonials = $page->testimonials();
    $lightboxPhotos = array_map(fn (string $photo): array => $images->lightboxPhoto($photo, __('home.highlights.photos.'.$photo)), $photos);
    $lead = $testimonials->first();
@endphp

{{-- How the last edition went: photos that open full screen, the films, and what people said. --}}
<x-ui.section tone="white" data-section="highlights" id="highlights" spacing="lg">
    <div class="flex flex-wrap items-end justify-between gap-8">
        <x-ui.heading :eyebrow="__('home.highlights.eyebrow')" :title="__('home.highlights.title')" :lead="__('home.highlights.lead')" size="lg" />
        @if ($navigation->has('archive'))
            <x-ui.button :href="localized_route('archive')" variant="secondary" icon="arrow-right" data-reveal>{{ __('home.highlights.archive') }}</x-ui.button>
        @endif
    </div>

    <div x-data="lightbox(@js($lightboxPhotos), @js(__('pages/gallery.lightbox.counter')))" class="mt-14">
        <div class="grid auto-rows-[10rem] grid-cols-2 gap-3 sm:auto-rows-[12rem] md:grid-cols-4 md:gap-4 lg:auto-rows-[14rem]">
            @foreach ($photos as $photo)
                <button type="button" data-lightbox-item="{{ $loop->index }}" x-on:click="open({{ $loop->index }}, $event)" aria-label="{{ __('pages/gallery.open', ['number' => $page->formatter()->plain($loop->iteration), 'total' => $page->formatter()->plain(count($photos)), 'caption' => __('home.highlights.photos.'.$photo)]) }}" @class([
                    'group relative overflow-hidden rounded-[1.4rem] bg-cream-2 focus-visible:outline-offset-4',
                    'col-span-2 row-span-2' => $loop->index === 0,
                    'row-span-2' => in_array($loop->index, [3, 4], true),
                    'col-span-2' => $loop->index === 5,
                ]) data-reveal="scale">
                    <x-ui.img :key="$photo" :alt="__('home.highlights.photos.'.$photo)" :sizes="$loop->index === 0 ? '(min-width: 768px) 50vw, 100vw' : '(min-width: 768px) 25vw, 50vw'" class="size-full object-cover transition duration-[1.2s] ease-[var(--ease-out-quint)] group-hover:scale-[1.06]" />
                    <span class="absolute inset-x-0 bottom-0 flex translate-y-2 items-end justify-between gap-3 bg-gradient-to-t from-midnight/80 to-transparent p-4 text-left text-sm font-medium text-white opacity-0 transition duration-500 group-hover:translate-y-0 group-hover:opacity-100 group-focus-visible:translate-y-0 group-focus-visible:opacity-100" aria-hidden="true">
                        <span class="line-clamp-2">{{ __('home.highlights.photos.'.$photo) }}</span>
                        <span class="grid size-9 shrink-0 place-items-center rounded-full bg-white text-navy"><x-ui.icon name="plus" class="size-4" /></span>
                    </span>
                </button>
            @endforeach
        </div>
        <x-ui.lightbox-dialog />
    </div>

    @if ($navigation->has('gallery'))
        <p class="mt-6"><x-ui.link :href="localized_route('gallery')">{{ __('home.highlights.gallery') }}</x-ui.link></p>
    @endif

    @if ($videos->isNotEmpty())
        <div class="mt-20 flex items-center gap-4">
            <h3 class="font-display text-display-sm font-bold text-navy">{{ __('home.highlights.videos') }}</h3>
            <span class="stitch-x flex-1 text-sand-2" aria-hidden="true"></span>
        </div>
        <div class="swipe-row mt-7 gap-5 sm:grid sm:grid-cols-2 lg:grid-cols-3" tabindex="0" role="region" aria-label="{{ __('home.highlights.videos') }}">
            @foreach ($videos->take(3) as $video)
                <x-ui.youtube :id="$video->youtube_id" :title="$video->title" :poster="$video->poster" :caption="$video->speaker" data-reveal />
            @endforeach
        </div>
    @endif

    @if ($lead)
        <div class="mt-20 flex items-center gap-4">
            <h3 class="font-display text-display-sm font-bold text-navy">{{ __('home.highlights.quotes') }}</h3>
            <span class="stitch-x flex-1 text-sand-2" aria-hidden="true"></span>
        </div>

        <figure data-tone="green" class="relative isolate mt-7 overflow-hidden rounded-[2rem] bg-green p-8 text-white md:p-12" data-reveal>
            <svg class="absolute -top-10 -right-10 -z-10 size-72 text-white/[0.06]" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z" /><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z" /></svg>
            <blockquote class="max-w-4xl font-display text-[clamp(1.6rem,1.1rem+1.8vw,2.75rem)] leading-[1.15] font-semibold tracking-[-0.01em]">
                <p>“{{ $lead->quote }}”</p>
            </blockquote>
            <figcaption class="mt-8 flex items-center gap-4">
                @if ($lead->image)
                    <x-ui.img :key="$lead->image" alt="" sizes="56px" class="size-14 rounded-full object-cover ring-2 ring-yellow" />
                @endif
                <span>
                    <span class="block font-semibold">{{ $lead->person }}</span>
                    <span class="block text-sm text-white/70">{{ $lead->role }}</span>
                </span>
            </figcaption>
        </figure>

        @if ($testimonials->count() > 1)
            <div class="swipe-row mt-5 gap-5 sm:grid md:grid-cols-2 xl:grid-cols-4" tabindex="0" role="region" aria-label="{{ __('home.highlights.quotes') }}">
                @foreach ($testimonials->skip(1) as $testimonial)
                    <figure class="flex flex-col rounded-[1.5rem] bg-cream p-6 ring-1 ring-sand" data-reveal>
                        <x-ui.icon name="quote" class="size-7 text-crimson" />
                        <blockquote class="mt-4 flex-1 leading-relaxed text-ink">
                            <p>{{ $testimonial->quote }}</p>
                        </blockquote>
                        <figcaption class="mt-6 flex items-center gap-3">
                            @if ($testimonial->image)
                                <x-ui.img :key="$testimonial->image" alt="" sizes="44px" class="size-11 rounded-full object-cover" />
                            @else
                                <span class="grid size-11 place-items-center rounded-full bg-navy font-semibold text-white" aria-hidden="true">{{ mb_substr($testimonial->person, 0, 1) }}</span>
                            @endif
                            <span>
                                <span class="block font-semibold text-navy">{{ $testimonial->person }}</span>
                                <span class="block text-sm text-ink-soft">{{ $testimonial->role }}</span>
                            </span>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        @endif
    @endif
</x-ui.section>
