<?php

declare(strict_types=1);

namespace App\AddonCostDecorator;

final class TransportPriceDecorator extends AddonCostDecorator
{
    public function calculateFinalPrice(): int
    {

        $basePrice = $this->finalPrice->calculateFinalPrice();
        return $basePrice + 5;
    }

}
