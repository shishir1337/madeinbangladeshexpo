<?php

namespace App\Models;

use App\Enums\PersonGroup;
use App\Models\Concerns\HasSortOrder;
use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * Someone behind the expo or the chamber: patron, leadership, board or team.
 */
#[Fillable(['name', 'role', 'group', 'email', 'photo', 'bio', 'sort'])]
class Person extends Model
{
    /** @use HasFactory<PersonFactory> */
    use HasFactory, HasSortOrder, HasTranslations;

    /**
     * @var list<string>
     */
    public array $translatable = ['role', 'bio'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'group' => PersonGroup::class,
        ];
    }
}
