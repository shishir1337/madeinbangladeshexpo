<?php

namespace App\Http\Controllers;

use App\Models\Exhibitor;
use App\Models\Sector;
use App\Support\Content\MarkdownDocument;
use Illuminate\Contracts\View\View;

class SectorController extends Controller
{
    /**
     * The nine sectors, each with its sourced headline figure.
     */
    public function index(): View
    {
        return view('pages.sectors.index', [
            'sectors' => Sector::query()->ordered()->get(),
        ]);
    }

    /**
     * One sector's deep-dive: figure, HS chapters, what Brazil buys, rules, past exhibitors and neighbours.
     */
    public function show(Sector $sector): View
    {
        $sectors = Sector::query()->ordered()->get();
        $position = $sectors->search(fn (Sector $candidate): bool => $candidate->is($sector));

        return view('pages.sectors.show', [
            'sector' => $sector,
            'body' => filled($sector->body) ? new MarkdownDocument($sector->body) : null,
            'rules' => array_values(array_filter((array) $sector->rules)),
            'exhibitors' => Exhibitor::query()->with('edition')->whereBelongsTo($sector)->ordered()->get()->groupBy('edition_id'),
            'previous' => $sectors->get($position - 1) ?? $sectors->last(),
            'next' => $sectors->get($position + 1) ?? $sectors->first(),
        ]);
    }
}
