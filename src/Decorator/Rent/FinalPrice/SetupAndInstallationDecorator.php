<?php

declare(strict_types=1);

namespace App\Decorator\Rent\FinalPrice;

class SetupAndInstallationDecorator extends AddonCostDecorator
{
    public function calculateFinalPrice(): int
    {
        $basePrice = $this->finalPrice->calculateFinalPrice();
        return $basePrice + 20;
    }

    public function handle(\App\DTO\RentAddOnsDto $rentAddOnsDto): bool
    {
        return true;
    }

}
