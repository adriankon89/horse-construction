<?php

declare(strict_types=1);

namespace App\Discount;

use App\Entity\Rent;

interface DiscountStrategyFactoryInterface
{
    public function createStrategy(Rent $rent): ?DiscountStrategyInterface;
}
