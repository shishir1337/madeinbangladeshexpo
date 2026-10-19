@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php
    $coverage = $page->coverage();
@endphp

@if ($coverage->isNotEmpty())
    <x-ui.section tone="sand" data-section="press" id="press">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-ui.heading :eyebrow="__('home.press.eyebrow')" :title="__('home.press.title')" :lead="__('home.press.lead')" />
            @if ($navigation->has('news'))
                <x-ui.button :href="localized_route('news')" variant="secondary" icon="arrow-right">{{ __('home.press.all') }}</x-ui.button>
            @endif
        </div>

        <ul class="mt-12 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($coverage as $article)
                <li data-reveal data-reveal-delay="{{ ($loop->index % 3) * 0.06 }}">
                    <article class="group relative flex h-full flex-col rounded-[1.5rem] bg-white p-6 shadow-soft ring-1 ring-ink/5 transition duration-300 hover:-translate-y-1 hover:shadow-lift md:p-7">
                        <div class="flex items-center justify-between gap-4">
                            <p class="font-display text-lg font-semibold text-green">{{ $article->source_name }}</p>
                            <time datetime="{{ $article->published_at->toDateString() }}" class="shrink-0 text-sm text-ink-soft">{{ $page->formatter()->date($article->published_at) }}</time>
                        </div>
                        <h3 class="mt-4 font-display text-xl leading-snug font-semibold text-navy">{{ $article->title }}</h3>
                        @if ($article->excerpt)
                            <p class="mt-3 line-clamp-3 leading-relaxed text-ink-soft">{{ $article->excerpt }}</p>
                        @endif
                        <p class="mt-auto pt-6">
                            <a href="{{ $article->source_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 font-semibold text-navy after:absolute after:inset-0 after:rounded-[1.5rem]">
                                <span class="link-underline">{{ __('home.press.read', ['source' => $article->source_name]) }}</span>
                                <x-ui.icon name="arrow-up-right" class="size-4 transition group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
                                <span class="sr-only">{{ __('home.press.new_tab') }}</span>
                            </a>
                        </p>
                    </article>
                </li>
            @endforeach
        </ul>
    </x-ui.section>
@endif
