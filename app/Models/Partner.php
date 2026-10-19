<?php

namespace App\Models;

use App\Enums\PartnerRole;
use App\Models\Concerns\HasSortOrder;
use Database\Factories\PartnerFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/**
 * An organisation behind an edition, grouped by its role.
 */
#[Fillable(['edition_id', 'name', 'role', 'url', 'logo', 'sort'])]
class Partner extends Model
{
    /** @use HasFactory<PartnerFactory> */
    use HasFactory, HasSortOrder, HasTranslations;

    /**
     * @var list<string>
     */
    public array $translatable = ['name'];

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
            'role' => PartnerRole::class,
        ];
    }
}
