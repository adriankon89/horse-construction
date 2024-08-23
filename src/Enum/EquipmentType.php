<?php

declare(strict_types=1);

namespace App\Enum;

enum EquipmentType: string
{
    case Drill = 'Drill';
    case Dehumidifier = 'Dehumidifier';

    public function toString(): string
    {
        return $this->value;
    }
}
