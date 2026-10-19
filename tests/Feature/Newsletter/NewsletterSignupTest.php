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

    public function test_unsubscribe_link_unsubscribes(): void
    {
        $subscription = NewsletterSubscription::factory()->confirmed()->create();

        $this->get($subscription->unsubscribeUrl())->assertOk();

        $this->assertNotNull($subscription->fresh()->unsubscribed_at);
    }
}
