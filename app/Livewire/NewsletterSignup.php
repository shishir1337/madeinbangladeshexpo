<?php

namespace App\Livewire;

use App\Mail\ConfirmNewsletterSubscription;
use App\Models\NewsletterSubscription;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * Double opt-in newsletter sign-up. Every outcome (new, pending, already confirmed, bot) shows the same
 * success message, so the form never reveals whether an address is subscribed.
 */
class NewsletterSignup extends Component
{
    public string $email = '';

    public bool $consent = false;

    /**
     * Honeypot: hidden from people, filled in by bots.
     */
    public string $website = '';

    public bool $submitted = false;

    /**
     * The page language when the form was rendered; Livewire update requests do not run SetLocale.
     */
    #[Locked]
    public string $locale = '';

    public function mount(): void
    {
        $this->locale = app()->getLocale();
    }

    public function submit(): void
    {
        app()->setLocale($this->locale ?: app()->getLocale());

        $rateLimitKey = 'newsletter:'.request()->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, config('expo.rate_limits.newsletter_per_minute'))) {
            $this->addError('email', __('newsletter.errors.too_many'));

            return;
        }

        if ($this->website !== '') {
            $this->submitted = true;

            return;
        }

        $this->validate(
            [
                'email' => ['required', 'string', 'email', 'max:254'],
                'consent' => ['accepted'],
            ],
            [
                'email.required' => __('newsletter.errors.email'),
                'email.email' => __('newsletter.errors.email'),
                'email.max' => __('newsletter.errors.email'),
                'consent.accepted' => __('newsletter.errors.consent'),
            ],
        );

        RateLimiter::hit($rateLimitKey);

        $subscription = NewsletterSubscription::firstOrNew(['email' => Str::lower(trim($this->email))]);

        if (! $subscription->exists || ! $subscription->isConfirmed()) {
            $subscription->fill([
                'locale' => $this->locale,
                'consent_version' => config('expo.consent.newsletter_version'),
                'consented_at' => now(),
                'consent_ip' => request()->ip(),
                'confirmed_at' => null,
                'unsubscribed_at' => null,
            ])->save();

            Mail::to($subscription->email)->locale($subscription->locale)->send(new ConfirmNewsletterSubscription($subscription));
        }

        $this->reset('email', 'consent');
        $this->submitted = true;
    }

    public function render(): View
    {
        return view('livewire.newsletter-signup');
    }
}
