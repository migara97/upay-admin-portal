<?php

namespace App\Enums;

enum BillPaymentType: string
{
    case ACCOUNT = 'ACCOUNT';
    case CARD    = 'CARD';

    public function labels(): string
    {
        return match ($this) {
            self::ACCOUNT => "Account Payment",
            self::CARD    => "Card Payment",
        };
    }
}
