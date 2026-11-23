<?php

namespace App\Models;

use App\Enums\TourStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

#[Fillable([
    'name',
    'slug',
    'year',
    'country',
    'summary',
    'description',
    'itinerary',
    'duration_days',
    'group_size',
    'date_label',
    'start_date',
    'end_date',
    'price_gbp',
    'price_usd',
    'single_supplement_gbp',
    'single_supplement_usd',
    'status',
    'status_label',
    'image',
    'is_featured',
    'is_published',
    'sort_order',
    'meta_title',
    'meta_description',
])]
class Tour extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'duration_days' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
            'price_gbp' => 'integer',
            'price_usd' => 'integer',
            'single_supplement_gbp' => 'integer',
            'single_supplement_usd' => 'integer',
            'status' => TourStatus::class,
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Resolve the badge label shown on the public tours page.
     */
    public function statusLabel(): string
    {
        return filled($this->status_label) ? $this->status_label : $this->status->label();
    }

    /**
     * Resolve the public badge CSS modifier for the tour status.
     */
    public function statusBadgeClass(): string
    {
        return match ($this->status) {
            TourStatus::Available => 'bta-badge-available',
            TourStatus::Full => 'bta-badge-full',
            TourStatus::Provisional => 'bta-badge-provisional',
        };
    }

    /**
     * Bookings made against this tour.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Resolve the public URL for the tour image.
     */
    public function imageUrl(): ?string
    {
        if (blank($this->image)) {
            return null;
        }

        if (Str::startsWith($this->image, ['http://', 'https://', '//'])) {
            return $this->image;
        }

        return asset('uploads/'.ltrim($this->image, '/'));
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('is_published', true);
    }

    #[Scope]
    protected function forYear(Builder $query, int $year): void
    {
        $query->where('year', $year);
    }

    #[Scope]
    protected function featured(Builder $query): void
    {
        $query->where('is_featured', true);
    }

    #[Scope]
    protected function ordered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('name');
    }
}
