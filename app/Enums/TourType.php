<?php

namespace App\Enums;

enum TourType: string
{
    case Scheduled = 'scheduled';
    case Custom = 'custom';

    public function label(): string
    {
        return match ($this) {
            self::Scheduled => 'Scheduled departure',
            self::Custom => 'Custom tour',
        };
    }
}
