<?php

declare(strict_types=1);

namespace App\Service;

use App\Discount\DefaultDiscountStrategyFactory;
use App\DTO\RentAddOnsDto;
use App\Entity\Rent;
use App\Factory\Rent\FinalPriceDecoratorFactory;

class FinalPriceService
{
    public function __construct(
        private FinalPriceDecoratorFactory $finalPriceDecoratorFactory,
    ) {

    }

    public function calculateFinalPrice(Rent $rent, RentAddOnsDto $rentAddOnsDto): int
    {
        $rent->setInitialPrice();
        $decorator = $this->finalPriceDecoratorFactory->applyDecorators($rent, $rentAddOnsDto);
        return $decorator->calculateFinalPrice();
    }
}
