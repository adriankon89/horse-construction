<?php

declare(strict_types=1);

namespace App\Decorator\Rent\FinalPrice;

use App\DTO\RentAddOnsDto;
use App\Entity\Rent;

abstract class AddonCostDecorator implements FinalPriceInterface
{
    public function __construct(protected FinalPriceInterface $finalPrice)
    {
    }

    abstract public function calculateFinalPrice(): int;

    abstract public function handle(RentAddOnsDto $rentAddOnsDto): bool;

    public function getRent(): Rent
    {
        return $this->finalPrice->getRent();
    }

}
