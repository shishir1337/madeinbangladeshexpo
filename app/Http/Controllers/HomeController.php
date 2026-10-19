<?php

namespace App\Http\Controllers;

use App\Settings\GeneralSettings;
use App\Support\Editions\CurrentEdition;
use App\Support\Localization\LocaleFormatter;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Show the home page for the current edition, in the request's language.
     */
    public function __invoke(CurrentEdition $currentEdition, LocaleFormatter $formatter, GeneralSettings $settings): View
    {
        $edition = $currentEdition->get();

        return view('home', [
            'edition' => $edition,
            'dateRange' => $edition === null ? null : $formatter->dateRange($edition->starts_on, $edition->ends_on),
            'settings' => $settings,
        ]);
    }
}
