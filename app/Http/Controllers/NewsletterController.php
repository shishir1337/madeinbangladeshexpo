<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NewsletterController extends Controller
{
    /**
     * The signed link in the confirmation mail. Opening it shows a button (GET), and only pressing it confirms
     * (POST), so mail scanners that follow links cannot subscribe anyone. The signature is checked before the
     * id is looked up, so a forged link never reveals whether an id exists.
     */
    public function confirm(Request $request, string $subscription): Response
    {
        if (! $request->hasValidSignature()) {
            return response()->view('newsletter.expired', status: 403);
        }

        $record = NewsletterSubscription::findOrFail($subscription);

        if (! $record->canBeConfirmed()) {
            return response()->view('newsletter.expired', status: 403);
        }

        if ($request->isMethod('GET')) {
            return response()->view('newsletter.confirm', ['action' => $request->fullUrl()]);
        }

        if (! $record->isConfirmed()) {
            $record->update(['confirmed_at' => now(), 'unsubscribed_at' => null]);
            $record->recordConsent('confirmed');
        }

        return response()->view('newsletter.confirmed');
    }

    /**
     * Unsubscribe from the signed link in every newsletter mail.
     */
    public function unsubscribe(Request $request, string $subscription): Response
    {
        if (! $request->hasValidSignature()) {
            return response()->view('newsletter.unsubscribe-invalid', status: 403);
        }

        $record = NewsletterSubscription::findOrFail($subscription);

        if ($record->unsubscribed_at === null) {
            $record->update(['unsubscribed_at' => now()]);
            $record->recordConsent('unsubscribed');
        }

        return response()->view('newsletter.unsubscribed');
    }
}
