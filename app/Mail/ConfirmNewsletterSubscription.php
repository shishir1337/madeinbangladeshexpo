<?php

namespace App\Mail;

use App\Models\NewsletterSubscription;
use App\Support\Localization\LocaleFormatter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * The double opt-in confirmation, sent in the subscriber's language.
 */
class ConfirmNewsletterSubscription extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public NewsletterSubscription $subscription) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('newsletter.mail.subject'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.newsletter.confirm',
            with: [
                'url' => $this->subscription->confirmationUrl(),
                'days' => app(LocaleFormatter::class)->plain(NewsletterSubscription::CONFIRMATION_LINK_LIFETIME_DAYS),
            ],
        );
    }
}
