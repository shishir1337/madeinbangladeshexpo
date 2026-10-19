<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Show the home page.
     */
    public function __invoke(): View
    {
        return view('home');
    }
}
