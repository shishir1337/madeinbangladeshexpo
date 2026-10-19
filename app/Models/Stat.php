<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use Database\Factories\StatFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * A sourced figure shown on the site, e.g. "US$215m, Bangladesh's exports to Brazil (EPB, FY2025-26)".
 */
#[Fillable(['key', 'value', 'decimals', 'prefix', 'suffix', 'label', 'source', 'as_of', 'placement', 'sort'])]
class Stat extends Model
{
    /** @use HasFactory<StatFactory> */
    use HasFactory, HasSortOrder, HasTranslations;

    /**
     * @var list<string>
     */
    public array $translatable = ['suffix', 'label'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'value' => 'float',
            'decimals' => 'integer',
        ];
    }
}
