<?php

namespace App\Factory\Rent;

use App\Entity\Rent;
use App\Decorator\Rent\FinalPrice\BaseFinalPrice;
use App\Decorator\Rent\FinalPrice\FinalPriceInterface;
use App\DTO\RentAddOnsDto;

class FinalPriceDecoratorFactory
{
    private DecoratorRegistry $decoratorRegistry;

    public function __construct(DecoratorRegistry $decoratorRegistry)
    {
        $this->decoratorRegistry = $decoratorRegistry;
    }

    public function applyDecorators(Rent $rent, RentAddOnsDto $addOnsDto): FinalPriceInterface
    {
        $baseRent = new BaseFinalPrice($rent);
        foreach ($this->decoratorRegistry->getAll() as $decoratorClass) {
            $decorator = new $decoratorClass($baseRent);
            if ($decorator->handle($addOnsDto)) {
                $baseRent = $decorator;
            }
        }

        return $baseRent;
    }
}
