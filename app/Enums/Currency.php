<?php

namespace App\Enums;

enum Currency: string
{
    case Gbp = 'gbp';
    case Usd = 'usd';

    public function label(): string
    {
        return match ($this) {
            self::Gbp => 'GBP',
            self::Usd => 'USD',
        };
    }

    public function symbol(): string
    {
        return match ($this) {
            self::Gbp => '£',
            self::Usd => '$',
        };
    }
}
