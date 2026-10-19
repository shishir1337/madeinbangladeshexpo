<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use App\Models\Concerns\ResolvesByLocalizedSlug;
use App\Support\Localization\HasLocalizedSlug;
use Database\Factories\SectorFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

/**
 * One of the expo's product sectors, with a sourced headline figure, the HS chapters it covers, a Markdown
 * deep-dive and the import rules to know.
 */
#[Fillable(['slug', 'name', 'summary', 'icon', 'image', 'figure_value', 'figure_decimals', 'figure_prefix', 'figure_suffix', 'figure_label', 'figure_source', 'hs_chapters', 'body', 'rules', 'sort'])]
class Sector extends Model implements HasLocalizedSlug
{
    /** @use HasFactory<SectorFactory> */
    use HasFactory, HasSortOrder, HasTranslations, ResolvesByLocalizedSlug;

    /**
     * @var list<string>
     */
    public array $translatable = ['slug', 'name', 'summary', 'figure_suffix', 'figure_label', 'body', 'rules'];

    /**
     * @return HasMany<Exhibitor, $this>
     */
    public function exhibitors(): HasMany
    {
        return $this->hasMany(Exhibitor::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'figure_value' => 'float',
            'figure_decimals' => 'integer',
            'hs_chapters' => 'array',
        ];
    }
}
