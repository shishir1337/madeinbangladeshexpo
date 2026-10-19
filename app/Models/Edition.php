<?php

namespace App\Models;

use App\Enums\EditionStatus;
use Carbon\CarbonImmutable;
use Database\Factories\EditionFactory;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/**
 * One yearly expo. `opening_at` is stored in UTC; `current_marker` is a generated column that is never written.
 */
#[Guarded(['current_marker'])]
#[Hidden(['current_marker'])]
class Edition extends Model
{
    /** @use HasFactory<EditionFactory> */
    use HasFactory, HasTranslations;

    /**
     * @var list<string>
     */
    public array $translatable = ['name'];

    /**
     * @return BelongsTo<Venue, $this>
     */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    /**
     * The opening time as a wall-clock time in the given timezone, e.g. São Paulo or Dhaka.
     */
    public function openingAtIn(string $timezone): ?CarbonImmutable
    {
        return $this->opening_at?->setTimezone($timezone);
    }

    /**
     * @param  Builder<Edition>  $query
     */
    public function scopeCurrent(Builder $query): void
    {
        $query->where('is_current', true);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'starts_on' => 'immutable_date',
            'ends_on' => 'immutable_date',
            'opening_at' => 'immutable_datetime',
            'status' => EditionStatus::class,
            'is_current' => 'boolean',
        ];
    }
}
