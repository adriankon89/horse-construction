<?php

declare(strict_types=1);

namespace App\Enum;

enum EquipmentDimension: string
{
    case A = 'A';
    case B = 'B';
    case C = 'C';

    public function toString(): string
    {
        return $this->value;
    }
}
