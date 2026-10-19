<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use Database\Factories\ExhibitorFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A company that exhibited at, or is confirmed for, an edition.
 */
#[Fillable(['edition_id', 'sector_id', 'name', 'website', 'logo', 'sort'])]
class Exhibitor extends Model
{
    /** @use HasFactory<ExhibitorFactory> */
    use HasFactory, HasSortOrder;

    /**
     * @return BelongsTo<Edition, $this>
     */
    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }

    /**
     * @return BelongsTo<Sector, $this>
     */
    public function sector(): BelongsTo
    {
        return $this->belongsTo(Sector::class);
    }
}
