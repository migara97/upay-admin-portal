<?php

namespace App\Enums;

enum PaymentStatusType: string
{
    case SUCCESS    = 'SUCCESS';
    case FAILED    = 'FAILED';
    case PENDING = 'PENDING';
    case INCOMPLETE = 'INCOMPLETE';
    case REFUNDED = 'REFUNDED';

    public function labels(): string
    {
        return match ($this) {
            self::SUCCESS    => "Success",
            self::FAILED    => "Failed",
            self::PENDING    => "Pending",
            self::INCOMPLETE    => "Incomplete",
            self::REFUNDED    => "Refunded",
        };
    }

    public function labelPowergridFilter(): string
    {
        return $this->labels();
    }
}
