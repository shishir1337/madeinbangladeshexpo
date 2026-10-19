<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NewsletterController extends Controller
{
    /**
     * Confirm a subscription from the signed link in the confirmation mail. A tampered or expired link
     * shows a friendly page (403) and changes nothing.
     */
    public function confirm(Request $request, NewsletterSubscription $subscription): Response
    {
        if (! $request->hasValidSignature()) {
            return response()->view('newsletter.expired', status: 403);
        }

        if ($subscription->confirmed_at === null || $subscription->unsubscribed_at !== null) {
            $subscription->update(['confirmed_at' => now(), 'unsubscribed_at' => null]);
        }

        return response()->view('newsletter.confirmed');
    }

    /**
     * Unsubscribe from the signed link in every newsletter mail.
     */
    public function unsubscribe(Request $request, NewsletterSubscription $subscription): Response
    {
        if (! $request->hasValidSignature()) {
            return response()->view('newsletter.expired', status: 403);
        }

        if ($subscription->unsubscribed_at === null) {
            $subscription->update(['unsubscribed_at' => now()]);
        }

        return response()->view('newsletter.unsubscribed');
    }
}
