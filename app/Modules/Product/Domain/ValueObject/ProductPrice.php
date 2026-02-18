<?php

declare(strict_types=1);

namespace App\Modules\Product\Domain\ValueObject;

class ProductPrice
{
    private float $value;
    public function __construct(float $value)
    {
        if ($value < 0) {
            throw new \DomainException('Price cannot be negative');
        }
        $this->value = $value;
    }

    public function value(): float
    {
        return $this->value;
    }
}
