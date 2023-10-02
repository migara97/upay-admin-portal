<?php

namespace App\Enums;

enum PermissionCategory: int
{
    case Other = 0;
    case Biller = 1;

    public function labels(): string
    {
        return match ($this) {
            self::Other    => "General",
            self::Biller   => "Biller Management",
        };
    }

    // Returns labels for PowerGrid Select Filter
    public function labelPowergridFilter(): string
    {
        return $this->labels();
    }
}