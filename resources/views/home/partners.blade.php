@inject('navigation', 'App\Support\Navigation\SiteNavigation')

@php($groups = $page->partnersByRole())

{{-- Who is behind the expo, by role, and an open place for the next partner. --}}
@if ($groups->isNotEmpty())
    <section data-section="partners" data-tone="white" class="border-t border-sand bg-white py-16 md:py-20">
        <div class="container-site">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <h2 class="eyebrow flex items-center gap-3"><span class="stitch-x w-7 opacity-60" aria-hidden="true"></span>{{ __('home.partners.title') }}</h2>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($groups as $role => $partners)
                    @foreach ($partners as $partner)
                        <div data-partner-role="{{ $role }}" class="flex items-center gap-4 rounded-[1.4rem] bg-cream p-5 ring-1 ring-sand" data-reveal>
                            @if ($partner->logo)
                                <x-ui.img :key="$partner->logo" alt="" sizes="56px" class="size-14 rounded-xl bg-white object-contain p-1" />
                            @else
                                <span class="grid size-14 shrink-0 place-items-center rounded-xl bg-navy text-white" aria-hidden="true"><x-ui.icon name="landmark" class="size-6" /></span>
                            @endif
                            <div class="min-w-0">
                                <p class="text-xs font-semibold tracking-[0.12em] text-green-700 uppercase">{{ __("home.partners.roles.{$role}") }}</p>
                                @if ($partner->url)
                                    <a href="{{ $partner->url }}" target="_blank" rel="noopener" class="mt-1 block leading-snug font-semibold text-navy link-underline">{{ $partner->name }}</a>
                                @else
                                    <p class="mt-1 leading-snug font-semibold text-navy">{{ $partner->name }}</p>
                                @endif
                                @if ($partner->edition)
                                    <p class="mt-0.5 text-sm text-ink-soft">{{ __('home.partners.edition', ['edition' => $page->formatter()->plain((int) $partner->edition->slug)]) }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endforeach

                @if ($navigation->has('sponsorship'))
                    <a href="{{ localized_route('sponsorship') }}" class="group flex items-center gap-4 rounded-[1.4rem] border-2 border-dashed border-sand-2 p-5 transition hover:border-green hover:bg-green-50" data-reveal>
                        <span class="grid size-14 shrink-0 place-items-center rounded-xl bg-yellow text-navy transition group-hover:rotate-90"><x-ui.icon name="plus" class="size-6" /></span>
                        <span>
                            <span class="block font-semibold text-navy">{{ __('home.partners.become') }}</span>
                            <span class="block text-sm text-ink-soft">{{ __('home.partners.become_lead') }}</span>
                        </span>
                    </a>
                @endif
            </div>
        </div>
    </section>
@endif
