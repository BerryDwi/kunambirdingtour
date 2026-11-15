<?php

namespace App\Enums;

enum RoomPreference: string
{
    case TwinShare = 'twin_share';
    case SingleSupplement = 'single_supplement';

    public function label(): string
    {
        return match ($this) {
            self::TwinShare => 'Twin share',
            self::SingleSupplement => 'Single supplement',
        };
    }
}
