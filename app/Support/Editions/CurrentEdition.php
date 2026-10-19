<?php

namespace App\Support\Editions;

use App\Models\Edition;

/**
 * The edition the site is promoting, looked up once per request (bound as scoped).
 */
class CurrentEdition
{
    private bool $resolved = false;

    private ?Edition $edition = null;

    public function get(): ?Edition
    {
        if (! $this->resolved) {
            $this->edition = Edition::query()->current()->with('venue')->first();
            $this->resolved = true;
        }

        return $this->edition;
    }
}
