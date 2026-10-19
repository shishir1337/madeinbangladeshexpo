<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use Database\Factories\MilestoneFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/**
 * A moment in Brazil–Bangladesh relations or in the expo's own history, for the 1972→today timeline.
 */
#[Fillable(['edition_id', 'happened_on', 'date_label', 'title', 'body', 'image', 'sort'])]
class Milestone extends Model
{
    /** @use HasFactory<MilestoneFactory> */
    use HasFactory, HasSortOrder, HasTranslations;

    /**
     * @var list<string>
     */
    public array $translatable = ['date_label', 'title', 'body'];

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
            'happened_on' => 'immutable_date',
        ];
    }
}
