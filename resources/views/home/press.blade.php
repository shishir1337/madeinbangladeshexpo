@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php
    $coverage = $page->coverage();
@endphp

{{-- Press coverage as an index: date, publisher, headline. Each row opens the report on the publisher's site. --}}
@if ($coverage->isNotEmpty())
    <x-ui.section tone="cream" data-section="press" id="press" spacing="lg">
        <div class="grid gap-10 lg:grid-cols-[minmax(0,0.75fr)_minmax(0,1.25fr)] lg:gap-16">
            <div class="lg:sticky lg:top-28 lg:self-start">
                <x-ui.heading :eyebrow="__('home.press.eyebrow')" :title="__('home.press.title')" :lead="__('home.press.lead')" size="lg" />
                @if ($navigation->has('news'))
                    <x-ui.button :href="localized_route('news')" variant="secondary" icon="arrow-right" class="mt-8" data-reveal>{{ __('home.press.all') }}</x-ui.button>
                @endif
            </div>

            <ul class="border-t-2 border-navy">
                @foreach ($coverage as $article)
                    <li class="border-b border-sand-2" data-reveal>
                        <article class="group relative isolate grid gap-x-6 gap-y-2 py-6 sm:grid-cols-[8.5rem_minmax(0,1fr)_auto] sm:items-baseline md:py-7">
                            <span class="absolute inset-y-0 -inset-x-4 -z-10 origin-left scale-x-0 rounded-xl bg-yellow transition-transform duration-500 ease-[var(--ease-out-quint)] group-hover:scale-x-100 group-focus-within:scale-x-100" aria-hidden="true"></span>
                            <div class="flex items-center gap-3 sm:block">
                                <time datetime="{{ $article->published_at->toDateString() }}" class="text-sm text-ink-soft tabular">{{ $page->formatter()->date($article->published_at) }}</time>
                                <p class="font-semibold text-green sm:mt-1">{{ $article->source_name }}</p>
                            </div>
                            <h3 class="font-display text-[clamp(1.25rem,1.05rem+0.7vw,1.65rem)] leading-snug font-bold text-navy">
                                <a href="{{ $article->source_url }}" target="_blank" rel="noopener" class="after:absolute after:inset-0 focus-visible:outline-none">
                                    {{ $article->title }}
                                    <span class="sr-only">— {{ __('home.press.read', ['source' => $article->source_name]) }} {{ __('home.press.new_tab') }}</span>
                                </a>
                            </h3>
                            <span class="hidden size-11 place-items-center rounded-full bg-white text-navy shadow-ring transition duration-500 group-hover:rotate-45 group-hover:bg-navy group-hover:text-white sm:grid" aria-hidden="true">
                                <x-ui.icon name="arrow-up-right" class="size-5" />
                            </span>
                        </article>
                    </li>
                @endforeach
            </ul>
        </div>
    </x-ui.section>
@endif
