<?php

declare(strict_types=1);

namespace App\Decorator\Rent\FinalPrice;

class InsuranceDecorator extends AddonCostDecorator
{
    private const int INSURANCE_COST = 50;

    public function calculateFinalPrice(): int
    {
        $basePrice = $this->finalPrice->calculateFinalPrice();
        return $basePrice + self::INSURANCE_COST;
    }

    public function handle(\App\DTO\RentAddOnsDto $rentAddOnsDto): bool
    {
        return true;
    }
}
