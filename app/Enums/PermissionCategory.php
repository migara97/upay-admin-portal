<?php

namespace App\Enums;

enum PermissionCategory: int
{
    case Other = 0;

    public function labels(): string
    {
        return match ($this) {
            self::Other => "General"
        };
    }

    // Returns labels for PowerGrid Select Filter
    public function labelPowergridFilter(): string
    {
        return $this->labels();
    }
}