<?php

namespace App\Models;

use Database\Factories\NewsletterSubscriptionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

/**
 * A double opt-in newsletter subscription. Nothing is sent but the confirmation mail until `confirmed_at` is set.
 */
#[Fillable(['email', 'locale', 'consent_version', 'consented_at', 'consent_ip', 'confirmed_at', 'unsubscribed_at'])]
class NewsletterSubscription extends Model
{
    /** @use HasFactory<NewsletterSubscriptionFactory> */
    use HasFactory;

    public const CONFIRMATION_LINK_LIFETIME_DAYS = 7;

    public function isConfirmed(): bool
    {
        return $this->confirmed_at !== null && $this->unsubscribed_at === null;
    }

    /**
     * A signed link, valid for 7 days, in the subscriber's language.
     */
    public function confirmationUrl(): string
    {
        return URL::temporarySignedRoute(
            "{$this->locale}.newsletter.confirm",
            now()->addDays(self::CONFIRMATION_LINK_LIFETIME_DAYS),
            ['subscription' => $this->id],
        );
    }

    /**
     * A signed unsubscribe link that does not expire, in the subscriber's language.
     */
    public function unsubscribeUrl(): string
    {
        return URL::signedRoute("{$this->locale}.newsletter.unsubscribe", ['subscription' => $this->id]);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'consented_at' => 'immutable_datetime',
            'confirmed_at' => 'immutable_datetime',
            'unsubscribed_at' => 'immutable_datetime',
        ];
    }
}
