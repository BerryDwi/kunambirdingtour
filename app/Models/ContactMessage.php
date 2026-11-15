<?php

namespace App\Models;

use App\Enums\MessageStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'first_name',
    'last_name',
    'email',
    'phone',
    'message',
    'status',
    'ip_address',
    'user_agent',
])]
class ContactMessage extends Model
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
            'status' => MessageStatus::class,
        ];
    }

    #[Scope]
    protected function forStatus(Builder $query, MessageStatus $status): void
    {
        $query->where('status', $status);
    }

    #[Scope]
    protected function unread(Builder $query): void
    {
        $query->where('status', MessageStatus::New);
    }
}
