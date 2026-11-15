<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['key', 'value', 'type', 'group'])]
class Setting extends Model
{
    use HasFactory;

    /**
     * Cache key for the keyed settings map.
     */
    private const CACHE_KEY = 'settings.values';

    /**
     * Flush the cached settings map whenever a setting changes.
     */
    protected static function booted(): void
    {
        $flush = function (): void {
            Cache::forget(self::CACHE_KEY);
        };

        static::saved($flush);
        static::deleted($flush);
    }

    /**
     * Get every setting as a key => value map.
     *
     * @return array<string, string|null>
     */
    public static function values(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, fn (): array => static::query()
            ->pluck('value', 'key')
            ->all());
    }

    /**
     * Resolve the mailbox that should receive public form notifications.
     */
    public static function officeEmail(): string
    {
        $values = static::values();

        return $values['office_email']
            ?? $values['contact_email']
            ?? config('admin.email')
            ?? config('mail.from.address')
            ?? 'office@birdtourasia.com';
    }

    #[Scope]
    protected function group(Builder $query, string $group): void
    {
        $query->where('group', $group);
    }
}
