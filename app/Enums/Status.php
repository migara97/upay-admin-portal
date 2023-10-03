<?php

namespace App\Enums;

enum Status: string
{
    case ACTIVE    = '1';
    case INACTIVE    = '0';

    public function labels(): string
    {
        return match ($this) {
            self::ACTIVE    => "Active",
            self::INACTIVE    => "Inactive",
        };
    }

    public function labelPowergridFilter(): string
    {
        return $this->labels();
    }
}
