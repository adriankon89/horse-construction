<?php

declare(strict_types=1);

namespace App\Enum;

enum EquipmentStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case REPAIR = 'repair';
    case RENTED = 'rented';
}
