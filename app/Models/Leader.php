<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['name', 'slug', 'region', 'badge_style', 'bio', 'photo', 'email', 'sort_order', 'is_published'])]
class Leader extends Model
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
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    /**
     * Resolve the public badge CSS classes for the leader.
     */
    public function badgeClass(): string
    {
        return match ($this->badge_style) {
            'info' => 'bg-info-subtle text-info',
            'warning' => 'bg-warning-subtle text-warning',
            default => 'bg-success-subtle text-success',
        };
    }

    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('is_published', true);
    }

    #[Scope]
    protected function ordered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Resolve the public URL for the leader photo.
     */
    public function photoUrl(): ?string
    {
        if (blank($this->photo)) {
            return null;
        }

        if (Str::startsWith($this->photo, ['http://', 'https://', '//'])) {
            return $this->photo;
        }

        return asset('uploads/'.ltrim($this->photo, '/'));
    }
}
