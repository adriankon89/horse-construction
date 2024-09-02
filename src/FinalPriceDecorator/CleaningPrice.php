<?php

declare(strict_types=1);

namespace App\FinalPriceDecorator;

final class CleaningPrice extends FinalPriceDecorator
{
    public function calculateFinalPrice(): int
    {

        $basePrice = $this->finalPrice->calculateFinalPrice();
        return $basePrice + 40;
    }
}
