<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use Database\Factories\SectorFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * One of the expo's product sectors, with a sourced headline figure.
 */
#[Fillable(['slug', 'name', 'summary', 'icon', 'image', 'figure_value', 'figure_decimals', 'figure_prefix', 'figure_suffix', 'figure_label', 'figure_source', 'sort'])]
class Sector extends Model
{
    /** @use HasFactory<SectorFactory> */
    use HasFactory, HasSortOrder, HasTranslations;

    /**
     * @var list<string>
     */
    public array $translatable = ['slug', 'name', 'summary', 'figure_suffix', 'figure_label'];

    /**
     * The URL slug in a locale: translated for Portuguese, English for English and Bangla.
     */
    public function localizedSlug(string $locale): string
    {
        return $this->getTranslation('slug', $locale);
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
        ];
    }
}
