@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php
    $photos = ['expo25-welcome', 'expo25-stand-accessories', 'expo25-speaker-shahriar-ahmed', 'expo25-stand-sts', 'expo25-guests', 'expo25-speaker-saiful-alam'];
    $videos = $page->videos();
    $testimonials = $page->testimonials();
@endphp

<x-ui.section tone="white" data-section="highlights" id="highlights">
    <div class="flex flex-wrap items-end justify-between gap-6">
        <x-ui.heading :eyebrow="__('home.highlights.eyebrow')" :title="__('home.highlights.title')" :lead="__('home.highlights.lead')" />
        @if ($navigation->has('archive'))
            <x-ui.button :href="localized_route('archive')" variant="secondary" icon="arrow-right">{{ __('home.highlights.archive') }}</x-ui.button>
        @endif
    </div>

    <div class="mt-12 grid auto-rows-[9rem] grid-cols-2 gap-3 sm:auto-rows-[11rem] md:grid-cols-4 md:gap-4 lg:auto-rows-[13rem]">
        @foreach ($photos as $photo)
            <figure @class([
                'relative overflow-hidden rounded-[1.25rem] bg-cream-2',
                'col-span-2 row-span-2' => $loop->index === 0,
                'row-span-2' => in_array($loop->index, [3, 4], true),
                'col-span-2' => $loop->index === 5,
            ]) data-reveal="scale" data-reveal-delay="{{ $loop->index * 0.05 }}">
                <x-ui.img :key="$photo" :alt="__('home.highlights.photos.'.$photo)" :sizes="$loop->index === 0 ? '(min-width: 768px) 50vw, 100vw' : '(min-width: 768px) 25vw, 50vw'" class="size-full object-cover transition duration-700 hover:scale-[1.04]" />
            </figure>
        @endforeach
    </div>

    @if ($videos->isNotEmpty())
        <h3 class="mt-16 font-display text-display-sm font-semibold text-navy">{{ __('home.highlights.videos') }}</h3>
        <div class="swipe-row mt-6 gap-5 sm:grid sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($videos->take(3) as $video)
                <x-ui.youtube :id="$video->youtube_id" :title="$video->title" :poster="$video->poster" :caption="$video->speaker" />
            @endforeach
        </div>
    @endif

    @if ($testimonials->isNotEmpty())
        <h3 class="mt-16 font-display text-display-sm font-semibold text-navy">{{ __('home.highlights.quotes') }}</h3>
        <div class="swipe-row mt-6 gap-5 sm:grid md:grid-cols-2 xl:grid-cols-3">
            @foreach ($testimonials as $testimonial)
                <figure @class([
                    'flex flex-col rounded-[1.75rem] p-7',
                    'bg-green text-white md:col-span-2 xl:col-span-1 xl:row-span-2' => $loop->first,
                    'bg-cream ring-1 ring-sand' => ! $loop->first,
                ]) @if ($loop->first) data-tone="green" @endif data-reveal data-reveal-delay="{{ $loop->index * 0.05 }}">
                    <x-ui.icon name="quote" class="size-8 text-yellow" />
                    <blockquote @class([
                        'mt-4 flex-1 leading-relaxed text-ink on-dark:text-white',
                        'font-display text-2xl leading-snug font-medium' => $loop->first,
                        'text-[1.05rem]' => ! $loop->first,
                    ])>
                        <p>{{ $testimonial->quote }}</p>
                    </blockquote>
                    <figcaption class="mt-6 flex items-center gap-3">
                        @if ($testimonial->image)
                            <x-ui.img :key="$testimonial->image" alt="" sizes="48px" class="size-12 rounded-full object-cover ring-2 ring-white" />
                        @else
                            <span class="grid size-12 place-items-center rounded-full bg-navy font-semibold text-white" aria-hidden="true">{{ mb_substr($testimonial->person, 0, 1) }}</span>
                        @endif
                        <span>
                            <span class="block font-semibold text-navy on-dark:text-white">{{ $testimonial->person }}</span>
                            <span class="block text-sm text-ink-soft on-dark:text-white/70">{{ $testimonial->role }}</span>
                        </span>
                    </figcaption>
                </figure>
            @endforeach
        </div>
    @endif
</x-ui.section>
