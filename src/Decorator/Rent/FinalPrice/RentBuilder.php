<?php

declare(strict_types=1);

namespace App\Decorator\Rent\FinalPrice;

use App\Entity\Rent;

class RentBuilder
{
    private FinalPriceInterface $baseFinalPrice;

    public function __construct(Rent $rent)
    {
        $this->baseFinalPrice = new BaseFinalPrice($rent);
    }

    public function addTransport(): self
    {
        $this->baseFinalPrice = new TransportDecorator($this->baseFinalPrice);
        return $this;
    }

    public function addCleaning(): self
    {
        $this->baseFinalPrice = new CleaningDecorator($this->baseFinalPrice);
        return $this;
    }

    public function addInsurance(): self
    {
        $this->baseFinalPrice = new InsuranceDecorator($this->baseFinalPrice);
        return $this;
    }

    public function getFinalRent()
    {
        return $this->baseFinalPrice;
        //return 20;
        // return $this->baseFinalPrice->getFinalPrice();
    }
}

/*
// Usage
$rentEntity = new Rent();
// ... set costs ...

$rentBuilder = new RentBuilder($rentEntity);
$finalRent = $rentBuilder->addTransport()->addCleaning()->getFinalRent();

echo $finalRent->calculatePrice(); // 130.0
*/
