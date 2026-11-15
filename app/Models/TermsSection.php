<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['number', 'title', 'nav_title', 'anchor', 'body', 'sort_order'])]
class TermsSection extends Model
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
            'number' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Resolve the label shown in the public quick navigation sidebar.
     */
    public function navTitle(): string
    {
        return filled($this->nav_title) ? $this->nav_title : $this->title;
    }

    /**
     * Resolve the anchor id used for the public section links.
     */
    public function anchorId(): string
    {
        return filled($this->anchor) ? $this->anchor : Str::slug($this->title);
    }

    #[Scope]
    protected function ordered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('number');
    }
}
