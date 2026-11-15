<?php

namespace App\Enums;

enum TourStatus: string
{
    case Available = 'available';
    case Full = 'full';
    case Provisional = 'provisional';

    /**
     * Human readable label used in admin screens and public badges.
     */
    public function label(): string
    {
        return match ($this) {
            self::Available => 'Available',
            self::Full => 'Tour is full',
            self::Provisional => 'Tour provisionally full',
        };
    }
}
