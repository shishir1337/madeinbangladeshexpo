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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
     * @return HasMany<Exhibitor, $this>
     */
    public function exhibitors(): HasMany
    {
        return $this->hasMany(Exhibitor::class);
    }

    /**
     * @return HasMany<ProgrammeSession, $this>
     */
    public function programmeSessions(): HasMany
    {
        return $this->hasMany(ProgrammeSession::class);
    }

    /**
     * @return HasMany<GalleryAlbum, $this>
     */
    public function galleryAlbums(): HasMany
    {
        return $this->hasMany(GalleryAlbum::class)->orderBy('sort');
    }

    /**
     * @return HasManyThrough<GalleryPhoto, GalleryAlbum, $this>
     */
    public function galleryPhotos(): HasManyThrough
    {
        return $this->hasManyThrough(GalleryPhoto::class, GalleryAlbum::class);
    }

    public function isPast(): bool
    {
        return $this->status === EditionStatus::Archived || $this->ends_on?->isPast() === true;
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
