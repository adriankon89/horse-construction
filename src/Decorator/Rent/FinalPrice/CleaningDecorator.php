<?php

declare(strict_types=1);

namespace App\Decorator\Rent\FinalPrice;

final class CleaningDecorator extends AddonCostDecorator
{
    private const int CLEANING_COST = 50;

    public function calculateFinalPrice(): int
    {
        $basePrice = $this->finalPrice->calculateFinalPrice();
        return $basePrice + self::CLEANING_COST;
    }

    public function handle(\App\DTO\RentAddOnsDto $rentAddOnsDto): bool
    {
        return true;
    }
}
