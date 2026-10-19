@inject('navigation', 'App\Support\Navigation\SiteNavigation')

<div>
    @if ($submitted)
        <div role="status" class="flex gap-4 rounded-2xl bg-green-50 p-5 text-green ring-1 ring-green/15">
            <x-ui.icon name="mail" class="mt-0.5 size-6" />
            <div>
                <p class="font-semibold">{{ __('newsletter.success_title') }}</p>
                <p class="mt-1 text-[0.95rem] leading-relaxed text-ink">{{ __('newsletter.success_body', ['days' => app(\App\Support\Localization\LocaleFormatter::class)->plain(\App\Models\NewsletterSubscription::CONFIRMATION_LINK_LIFETIME_DAYS)]) }}</p>
            </div>
        </div>
    @else
        <form wire:submit="submit" novalidate class="space-y-4">
            <div class="hidden" aria-hidden="true">
                <label for="newsletter-website">Website</label>
                <input id="newsletter-website" type="text" wire:model="website" tabindex="-1" autocomplete="off">
            </div>

            <div>
                <label for="newsletter-email" class="block text-sm font-semibold text-navy">{{ __('newsletter.email') }}</label>
                <div class="mt-2 flex flex-col gap-2 sm:flex-row">
                    <input
                        id="newsletter-email"
                        type="email"
                        wire:model="email"
                        autocomplete="email"
                        inputmode="email"
                        placeholder="{{ __('newsletter.placeholder') }}"
                        @error('email') aria-invalid="true" aria-describedby="newsletter-email-error" @enderror
                        class="h-12 min-w-0 flex-1 rounded-full border-0 bg-cream px-5 text-ink ring-1 ring-sand transition placeholder:text-ink-soft/70 focus:bg-white focus:ring-2 focus:ring-navy focus:outline-none aria-invalid:ring-crimson"
                    >
                    <x-ui.button type="submit" wire:loading.attr="disabled" wire:target="submit">
                        <span wire:loading.remove wire:target="submit">{{ __('newsletter.submit') }}</span>
                        <span wire:loading wire:target="submit">{{ __('newsletter.sending') }}</span>
                    </x-ui.button>
                </div>
                @error('email')
                    <p id="newsletter-email-error" class="mt-2 flex items-center gap-1.5 text-sm font-medium text-crimson">
                        <x-ui.icon name="alert-triangle" class="size-4" /> {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="flex items-start gap-3 text-sm leading-relaxed text-ink-soft">
                    <input
                        type="checkbox"
                        wire:model="consent"
                        @error('consent') aria-invalid="true" aria-describedby="newsletter-consent-error" @enderror
                        class="mt-0.5 size-5 shrink-0 rounded border-sand-2 text-green accent-green focus:ring-navy"
                    >
                    <span>
                        {{ __('newsletter.consent') }}
                        @if ($navigation->has('privacy'))
                            <a href="{{ localized_route('privacy') }}" class="font-semibold text-navy link-underline">{{ __('newsletter.privacy') }}</a>
                        @endif
                    </span>
                </label>
                @error('consent')
                    <p id="newsletter-consent-error" class="mt-2 flex items-center gap-1.5 text-sm font-medium text-crimson">
                        <x-ui.icon name="alert-triangle" class="size-4" /> {{ $message }}
                    </p>
                @enderror
            </div>
        </form>
    @endif
</div>
