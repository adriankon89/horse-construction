<?php

declare(strict_types=1);

namespace App\Discount;

use App\Entity\Rent;
use App\ValueObject\Price;

final class FirstRentDiscount implements DiscountStrategyInterface
{
    private const PERCENT_DISCOUNT_AMOUNT = 5;

    public function calculate(Rent $rent): void
    {
        $rentPrice = $rent->getPrice();
        $discountPrice  = ($rentPrice * self::PERCENT_DISCOUNT_AMOUNT) / 100;
        $priceAfterDiscount = $rentPrice - $discountPrice;
        $priceValueObject = new Price($priceAfterDiscount);

        $rent->setDiscount($discountPrice);
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
