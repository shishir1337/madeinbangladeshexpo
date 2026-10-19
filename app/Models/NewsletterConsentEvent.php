<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One step in a subscriber's consent history (signed up, confirmed, unsubscribed), kept as proof under LGPD
 * Art. 8 even after the subscription row changes.
 */
#[Fillable(['newsletter_subscription_id', 'event', 'consent_version', 'ip', 'user_agent'])]
class NewsletterConsentEvent extends Model
{
    public const UPDATED_AT = null;

    /**
     * @return BelongsTo<NewsletterSubscription, $this>
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(NewsletterSubscription::class, 'newsletter_subscription_id');
    }
}
