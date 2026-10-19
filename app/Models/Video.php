<?php

namespace App\Models;

use App\Models\Concerns\HasSortOrder;
use Database\Factories\VideoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

/**
 * A YouTube video, shown behind a click-to-load facade.
 */
#[Fillable(['edition_id', 'youtube_id', 'title', 'speaker', 'poster', 'sort'])]
class Video extends Model
{
    /** @use HasFactory<VideoFactory> */
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
}
