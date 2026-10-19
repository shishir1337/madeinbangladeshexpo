<?php

namespace App\Http\Controllers;

use App\Support\Navigation\SiteNavigation;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageInPreparationController extends Controller
{
    /**
     * A page of the full site that is not built yet: what it will hold, a way to be told when it opens, and the
     * pages next to it. Kept out of search engines until it has real content.
     */
    public function __invoke(Request $request, SiteNavigation $navigation): View
    {
        $page = Str::after($request->route()->getName(), '.');
        $group = $navigation->groupOf($page);

        return view('pages.in-preparation', [
            'page' => $page,
            'group' => $group,
            'related' => collect($group['items'] ?? [])->reject(fn (array $item): bool => $item['route'] === $page)->values(),
        ]);
    }
}
