<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use Database\Factories\TestimonialFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/**
 * An attributed quote about an edition.
 */
#[Fillable(['edition_id', 'quote', 'person', 'role', 'image', 'sort'])]
class Testimonial extends Model
{
    /** @use HasFactory<TestimonialFactory> */
    use HasFactory, HasSortOrder, HasTranslations;

    /**
     * @var list<string>
     */
    public array $translatable = ['quote', 'role'];

    /**
     * @return BelongsTo<Edition, $this>
     */
    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }
}
