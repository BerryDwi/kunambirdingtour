<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable([
    'title',
    'slug',
    'region',
    'kind',
    'summary',
    'cover_image',
    'report_url',
    'published_at',
    'is_featured',
    'sort_order',
    'is_published',
])]
class TourReport extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('is_published', true);
    }

    #[Scope]
    protected function featured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    #[Scope]
    protected function categories(Builder $query): void
    {
        $query->where('kind', 'category');
    }

    #[Scope]
    protected function latestCards(Builder $query): void
    {
        $query->where('kind', 'latest');
    }

    #[Scope]
    protected function ordered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderByDesc('published_at');
    }

    /**
     * Resolve the public URL for the report cover image.
     */
    public function coverImageUrl(): ?string
    {
        if (blank($this->cover_image)) {
            return null;
        }

        if (Str::startsWith($this->cover_image, ['http://', 'https://', '//'])) {
            return $this->cover_image;
        }

        return asset('uploads/'.ltrim($this->cover_image, '/'));
    }
}
