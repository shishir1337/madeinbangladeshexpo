<?php

namespace App\Http\Controllers;

use App\Enums\EditionStatus;
use App\Models\Edition;
use App\Models\Exhibitor;
use App\Models\GalleryAlbum;
use App\Models\Milestone;
use App\Models\ProgrammeSession;
use App\Models\Video;
use Illuminate\Contracts\View\View;

class ArchiveController extends Controller
{
    /**
     * The most recent archived edition: the road to it, key facts, programme, exhibitors, albums and videos.
     */
    public function __invoke(): View
    {
        $edition = Edition::query()
            ->with('venue')
            ->where('status', EditionStatus::Archived)
            ->orderByDesc('number')
            ->firstOrFail();

        $sessions = ProgrammeSession::query()->whereBelongsTo($edition)->orderBy('day')->ordered()->get();

        return view('pages.archive', [
            'edition' => $edition,
            'days' => $sessions->groupBy(fn (ProgrammeSession $session): string => $session->day->toDateString()),
            'exhibitors' => Exhibitor::query()->with('sector')->whereBelongsTo($edition)->ordered()->get(),
            'albums' => GalleryAlbum::query()->withCount('photos')->ordered()->get(),
            'milestones' => Milestone::query()->where('happened_on', '>=', $edition->starts_on->subYears(2))->where('happened_on', '<=', $edition->ends_on)->orderBy('happened_on')->get(),
            'videos' => Video::query()->ordered()->get(),
        ]);
    }
}
