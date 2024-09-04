<?php

declare(strict_types=1);

namespace App\AddonCostDecorator;

use App\Entity\Rent;

class BaseFinalPrice implements FinalPriceInterface
{
    public function __construct(protected Rent $rent)
    {

    }

    public function calculateFinalPrice(): int
    {
        return $this->rent->getFinalPrice();
    }

    public function getRent(): Rent
    {
        return $this->rent;
    }

}
