<?php

namespace App\Http\Controllers;

use App\Settings\GeneralSettings;
use App\View\HomePage;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Show the home page for the current edition, in the request's language.
     */
    public function __invoke(HomePage $page, GeneralSettings $settings): View
    {
        return view('home', [
            'page' => $page,
            'settings' => $settings,
        ]);
    }
}
