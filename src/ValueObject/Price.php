<?php

declare(strict_types=1);

namespace App\ValueObject;

use InvalidArgumentException;

class Price
{
    public function __construct(
        private  $price
    ) {
        if ($this->price < 0) {
            throw new InvalidArgumentException("Price cannot be negative.");
        }

    }

    public function getPrice()
    {
        return $this->price;
    }
}
