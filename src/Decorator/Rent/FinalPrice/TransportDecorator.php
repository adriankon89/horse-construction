<?php

declare(strict_types=1);

namespace App\Decorator\Rent\FinalPrice;

final class TransportDecorator extends AddonCostDecorator
{
    public function calculateFinalPrice(): int
    {
        $basePrice = $this->finalPrice->calculateFinalPrice();
        return $basePrice + 5;
    }

    public function handle(\App\DTO\RentAddOnsDto $rentAddOnsDto): bool
    {
        return true;
    }

}
