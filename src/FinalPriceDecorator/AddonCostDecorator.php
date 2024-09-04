<?php

declare(strict_types=1);

namespace App\FinalPriceDecorator;

use App\Entity\Rent;

abstract class AddonCostDecorator implements FinalPriceInterface
{
    public function __construct(protected FinalPriceInterface $finalPrice)
    {
    }

    abstract public function calculateFinalPrice(): int;

    public function getRent(): Rent
    {
        return $this->finalPrice->getRent();
    }

}
