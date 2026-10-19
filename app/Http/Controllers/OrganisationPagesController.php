<?php

namespace App\Http\Controllers;

use App\Enums\PersonGroup;
use App\Models\Person;
use App\Support\Seo\OrganizationSchema;
use App\View\AboutPage;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class OrganisationPagesController extends Controller
{
    /**
     * What the expo is, who it is for, why São Paulo and the current edition's facts.
     */
    public function about(AboutPage $page): View
    {
        return view('pages.about', ['page' => $page]);
    }

    /**
     * BBCCI: mission, objectives, services, governance, leaders, membership and the Dhaka office.
     */
    public function organiser(OrganizationSchema $organization): View
    {
        return view('pages.organiser', [
            'leaders' => $this->people(PersonGroup::Leadership),
            'structuredData' => ['@context' => 'https://schema.org'] + $organization->toArray(),
        ]);
    }

    /**
     * The people BBCCI has named, by group. Unnamed board seats are described, never invented.
     */
    public function committee(): View
    {
        return view('pages.committee', [
            'patrons' => $this->people(PersonGroup::Patron),
            'leaders' => $this->people(PersonGroup::Leadership),
            'board' => $this->people(PersonGroup::Board),
        ]);
    }

    /**
     * @return Collection<int, Person>
     */
    private function people(PersonGroup $group): Collection
    {
        return Person::query()->where('group', $group)->ordered()->get();
    }
}
