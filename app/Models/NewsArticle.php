<?php

namespace App\Models;

use App\Enums\NewsType;
use App\Models\Concerns\ResolvesByLocalizedSlug;
use App\Support\Localization\HasLocalizedSlug;
use Database\Factories\NewsArticleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * A newsroom item: BBCCI news, a press release, or a media report that links out to its publisher.
 */
#[Fillable(['type', 'slug', 'title', 'excerpt', 'body', 'image', 'source_name', 'source_url', 'published_at'])]
class NewsArticle extends Model implements HasLocalizedSlug
{
    /** @use HasFactory<NewsArticleFactory> */
    use HasFactory, HasTranslations, ResolvesByLocalizedSlug;

    /**
     * @var list<string>
     */
    public array $translatable = ['slug', 'title', 'excerpt', 'body'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => NewsType::class,
            'published_at' => 'immutable_datetime',
        ];
    }
}
