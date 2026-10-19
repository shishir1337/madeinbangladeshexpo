@php($groups = $page->partnersByRole())

@if ($groups->isNotEmpty())
    <section data-section="partners" data-tone="cream" class="border-y border-sand bg-cream py-12 md:py-16">
        <div class="container-site">
            <h2 class="sr-only">{{ __('home.partners.title') }}</h2>
            <div class="flex flex-wrap gap-x-16 gap-y-10">
                @foreach ($groups as $role => $partners)
                    <div data-partner-role="{{ $role }}">
                        <p class="eyebrow">{{ __("home.partners.roles.{$role}") }}</p>
                        <ul class="mt-4 flex flex-wrap items-center gap-x-8 gap-y-4">
                            @foreach ($partners as $partner)
                                <li class="flex items-center gap-3">
                                    @if ($partner->logo)
                                        <x-ui.img :key="$partner->logo" alt="" sizes="48px" class="size-12 rounded-xl" />
                                    @else
                                        <span class="grid size-12 place-items-center rounded-xl bg-navy text-white" aria-hidden="true"><x-ui.icon name="landmark" class="size-5" /></span>
                                    @endif
                                    <span>
                                        @if ($partner->url)
                                            <a href="{{ $partner->url }}" target="_blank" rel="noopener" class="font-semibold text-navy link-underline">{{ $partner->name }}</a>
                                        @else
                                            <span class="font-semibold text-navy">{{ $partner->name }}</span>
                                        @endif
                                        @if ($partner->edition)
                                            <span class="block text-sm text-ink-soft">{{ __('home.partners.edition', ['edition' => $page->formatter()->plain((int) $partner->edition->slug)]) }}</span>
                                        @endif
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
