<?php

declare(strict_types=1);

namespace App\Service;

use App\Discount\DefaultDiscountStrategyFactory;
use App\Entity\Rent;

class DiscountRentService
{
    public function __construct(
        private DefaultDiscountStrategyFactory $discountFactory
    ) {

    }

    public function calculateDiscount(Rent $rent): void
    {
        $rent->setInitialPrice();
        $factory = $this->discountFactory->createStrategy($rent);
        if($factory) {
            $factory->calculate($rent);
        }

    }
}
