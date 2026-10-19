<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use App\Models\Concerns\ResolvesByLocalizedSlug;
use App\Support\Localization\HasLocalizedSlug;
use Database\Factories\GalleryAlbumFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * A photo album, optionally tied to an edition, with a translated slug, title and description.
 */
#[Fillable(['edition_id', 'slug', 'title', 'description', 'cover', 'period', 'sort'])]
class GalleryAlbum extends Model implements HasLocalizedSlug
{
    /** @use HasFactory<GalleryAlbumFactory> */
    use HasFactory, HasSortOrder, HasTranslations, ResolvesByLocalizedSlug;

    /**
     * @var list<string>
     */
    public array $translatable = ['slug', 'title', 'description'];

    /**
     * @return BelongsTo<Edition, $this>
     */
    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }

    /**
     * @return HasMany<GalleryPhoto, $this>
     */
    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class)->orderBy('sort')->orderBy('id');
    }
}
