<?php

namespace App\Models;

use Database\Factories\VenueFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

#[Fillable(['name', 'address_line', 'district', 'city', 'state', 'postal_code', 'country_code', 'phone', 'website', 'highlights', 'latitude', 'longitude'])]
class Venue extends Model
{
    /** @use HasFactory<VenueFactory> */
    use HasFactory, HasTranslations;

    /**
     * @var list<string>
     */
    public array $translatable = ['highlights'];

    /**
     * @return HasMany<Edition, $this>
     */
    public function editions(): HasMany
    {
        return $this->hasMany(Edition::class);
    }

    /**
     * The one-line postal address, e.g. "Av. Professora Ida Kolb, 513, Casa Verde, São Paulo-SP, 02518-000".
     */
    public function fullAddress(): string
    {
        $cityState = $this->state ? "{$this->city}-{$this->state}" : $this->city;

        return collect([$this->address_line, $this->district, $cityState, $this->postal_code])->filter()->implode(', ');
    }

    /**
     * A Google Maps search link for the venue; no API key and no tracking parameters.
     */
    public function directionsUrl(): string
    {
        return 'https://www.google.com/maps/search/?api=1&query='.rawurlencode("{$this->name}, {$this->fullAddress()}");
    }

    /**
     * Short facts about the venue in the current language, e.g. "About 1,000 covered parking spaces".
     *
     * @return list<string>
     */
    public function highlightList(): array
    {
        $highlights = $this->getTranslation('highlights', app()->getLocale());

        return is_array($highlights) ? array_values($highlights) : [];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }
}
