<?php

namespace Tests\Feature\Newsletter;

use App\Livewire\NewsletterSignup;
use App\Mail\ConfirmNewsletterSubscription;
use App\Models\NewsletterSubscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Tests\TestCase;

class NewsletterSignupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    public function test_signup_requires_a_valid_email_and_consent(): void
    {
        Livewire::test(NewsletterSignup::class)
            ->set('email', 'not-an-email')
            ->call('submit')
            ->assertHasErrors(['email', 'consent'])
            ->assertSet('submitted', false);

        $this->assertDatabaseCount('newsletter_subscriptions', 0);
        Mail::assertNothingSent();
    }

    public function test_signup_sends_a_confirmation_mail_in_the_page_language(): void
    {
        app()->setLocale('pt_BR');

        Livewire::test(NewsletterSignup::class)
            ->set('email', 'compras@lojabrasil.com.br')
            ->set('consent', true)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('submitted', true);

        $subscription = NewsletterSubscription::sole();
        $this->assertSame('pt_BR', $subscription->locale);
        $this->assertNull($subscription->confirmed_at);
        $this->assertNotNull($subscription->consented_at);
        $this->assertSame(config('expo.consent.newsletter_version'), $subscription->consent_version);

        Mail::assertSent(ConfirmNewsletterSubscription::class, fn (ConfirmNewsletterSubscription $mail): bool => $mail->hasTo('compras@lojabrasil.com.br') && $mail->locale === 'pt_BR');
    }

    public function test_confirmation_link_confirms_the_subscription(): void
    {
        $subscription = NewsletterSubscription::factory()->create(['locale' => 'pt_BR']);

        $this->get($subscription->confirmationUrl())
            ->assertOk()
            ->assertSee('<html lang="pt-BR"', false);

        $this->assertNotNull($subscription->fresh()->confirmed_at);
    }

    public function test_tampered_confirmation_link_is_rejected(): void
    {
        $subscription = NewsletterSubscription::factory()->create();

        $this->get($subscription->confirmationUrl().'x')->assertForbidden();

        $expired = URL::temporarySignedRoute('en.newsletter.confirm', now()->subMinute(), ['subscription' => $subscription->id]);
        $this->get($expired)->assertForbidden();

        $this->assertNull($subscription->fresh()->confirmed_at);
    }

    public function test_duplicate_signup_is_idempotent_and_silent(): void
    {
        NewsletterSubscription::factory()->confirmed()->create(['email' => 'buyer@example.com']);

        Livewire::test(NewsletterSignup::class)
            ->set('email', 'Buyer@Example.com')
            ->set('consent', true)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('submitted', true);

        $this->assertDatabaseCount('newsletter_subscriptions', 1);
        Mail::assertNothingSent();

        NewsletterSubscription::factory()->create(['email' => 'pending@example.com']);

        Livewire::test(NewsletterSignup::class)
            ->set('email', 'pending@example.com')
            ->set('consent', true)
            ->call('submit')
            ->assertSet('submitted', true);

        $this->assertDatabaseCount('newsletter_subscriptions', 2);
        Mail::assertSent(ConfirmNewsletterSubscription::class, 1);
    }

    public function test_honeypot_blocks_bots_silently(): void
    {
        Livewire::test(NewsletterSignup::class)
            ->set('email', 'bot@example.com')
            ->set('consent', true)
            ->set('website', 'http://spam.example')
            ->call('submit')
            ->assertSet('submitted', true);

        $this->assertDatabaseCount('newsletter_subscriptions', 0);
        Mail::assertNothingSent();
    }

    public function test_signups_are_rate_limited(): void
    {
        foreach (range(1, 5) as $attempt) {
            Livewire::test(NewsletterSignup::class)->set('email', "person{$attempt}@example.com")->set('consent', true)->call('submit');
        }

        Livewire::test(NewsletterSignup::class)
            ->set('email', 'person6@example.com')
            ->set('consent', true)
            ->call('submit')
            ->assertHasErrors('email');

        $this->assertDatabaseCount('newsletter_subscriptions', 5);
    }

    public function test_repeat_signups_for_one_address_send_one_confirmation_per_cooldown(): void
    {
        $submit = fn () => Livewire::test(NewsletterSignup::class)
            ->set('email', 'victim@example.com')
            ->set('consent', true)
            ->call('submit')
            ->assertSet('submitted', true);

        $submit();
        $submit();
        $submit();

        Mail::assertSent(ConfirmNewsletterSubscription::class, 1);

        $this->travel(NewsletterSubscription::CONFIRMATION_RESEND_COOLDOWN_MINUTES + 1)->minutes();
        $submit();

        Mail::assertSent(ConfirmNewsletterSubscription::class, 2);
    }

    public function test_invalid_attempts_count_toward_the_rate_limit(): void
    {
        foreach (range(1, 5) as $attempt) {
            Livewire::test(NewsletterSignup::class)->set('email', 'not-an-email')->call('submit');
        }

        Livewire::test(NewsletterSignup::class)
            ->set('email', 'real@example.com')
            ->set('consent', true)
            ->call('submit')
            ->assertHasErrors('email')
            ->assertSet('submitted', false);

        Mail::assertNothingSent();
    }

    public function test_a_mail_failure_still_saves_the_signup_and_shows_success(): void
    {
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP is down'));

        Livewire::test(NewsletterSignup::class)
            ->set('email', 'buyer@example.com')
            ->set('consent', true)
            ->call('submit')
            ->assertHasNoErrors()
            ->assertSet('submitted', true);

        $this->assertDatabaseHas('newsletter_subscriptions', ['email' => 'buyer@example.com', 'confirmation_sent_at' => null]);
    }

    public function test_email_field_keeps_its_height_when_stacked_on_phones(): void
    {
        $html = Livewire::test(NewsletterSignup::class)->html();

        preg_match('/id="newsletter-email".*?class="([^"]+)"/s', $html, $match);
        $classes = explode(' ', $match[1]);

        $this->assertContains('h-12', $classes);
        $this->assertContains('sm:flex-1', $classes);
        $this->assertNotContains('flex-1', $classes, 'An unprefixed flex-1 collapses the input to its content height in the stacked phone layout.');
    }

    public function test_bangla_confirmation_mail_states_the_link_lifetime_in_bangla_digits(): void
    {
        $subscription = NewsletterSubscription::factory()->create(['locale' => 'bn']);

        $mail = (new ConfirmNewsletterSubscription($subscription))->locale('bn');

        $mail->assertSeeInHtml('এই লিংকটি ৭ দিন কার্যকর থাকবে।');
    }

    public function test_unsubscribe_link_unsubscribes(): void
    {
        $subscription = NewsletterSubscription::factory()->confirmed()->create();

        $this->get($subscription->unsubscribeUrl())->assertOk();

        $this->assertNotNull($subscription->fresh()->unsubscribed_at);
    }
}
