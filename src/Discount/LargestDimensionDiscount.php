<?php

declare(strict_types=1);

namespace App\Discount;

use App\Entity\Rent;
use App\ValueObject\Price;

final class LargestDimensionDiscount implements DiscountStrategyInterface
{
    public const int DISCOUNT_AMOUNT = 10;

    public function calculate(Rent $rent): void
    {
        $rentPrice = $rent->getPrice();
        $finalPrice  = $rentPrice - self::DISCOUNT_AMOUNT;
        $priceValueObject = new Price($finalPrice);

        $rent->setDiscount(self::DISCOUNT_AMOUNT);
        $rent->setFinalPrice($priceValueObject->getPrice());
    }

    public function handle(Rent $rent): void
    {

    }

    public function supports(Rent $rent): bool
    {
        return true;
    }


}
