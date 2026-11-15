<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\Currency;
use App\Enums\PaymentStatus;
use App\Enums\RoomPreference;
use App\Enums\TourType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'reference_code',
    'tour_id',
    'tour_type',
    'tour_name',
    'tour_year',
    'currency',
    'room_preference',
    'full_name',
    'email',
    'phone',
    'country',
    'participants_count',
    'birding_experience',
    'dietary_medical',
    'special_notes',
    'terms_accepted_at',
    'status',
    'payment_status',
    'ip_address',
    'user_agent',
])]
class Booking extends Model
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
            'tour_type' => TourType::class,
            'currency' => Currency::class,
            'room_preference' => RoomPreference::class,
            'status' => BookingStatus::class,
            'payment_status' => PaymentStatus::class,
            'participants_count' => 'integer',
            'terms_accepted_at' => 'datetime',
        ];
    }

    /**
     * The tour this booking refers to, when still available.
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    #[Scope]
    protected function forStatus(Builder $query, BookingStatus $status): void
    {
        $query->where('status', $status);
    }

    #[Scope]
    protected function pending(Builder $query): void
    {
        $query->where('status', BookingStatus::Pending);
    }
}
