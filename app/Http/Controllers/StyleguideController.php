<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class StyleguideController extends Controller
{
    /**
     * The living style guide: every UI component in every tone. Local and demo sites only.
     */
    public function __invoke(): View
    {
        abort_unless(app()->isLocal() || config('expo.demo_mode'), 404);

        return view('styleguide');
    }
}
