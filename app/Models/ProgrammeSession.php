<?php

namespace App\Models;

use App\Enums\SessionKind;
use App\Models\Concerns\HasSortOrder;
use Database\Factories\ProgrammeSessionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/**
 * One slot of an edition's programme: a day, an optional local time range and what happens.
 */
#[Fillable(['edition_id', 'day', 'starts_at', 'ends_at', 'title', 'kind', 'sort'])]
class ProgrammeSession extends Model
{
    /** @use HasFactory<ProgrammeSessionFactory> */
    use HasFactory, HasSortOrder, HasTranslations;

    /**
     * @var list<string>
     */
    public array $translatable = ['title'];

    /**
     * @return BelongsTo<Edition, $this>
     */
    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'day' => 'immutable_date',
            'kind' => SessionKind::class,
        ];
    }
}
