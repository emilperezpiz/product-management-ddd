<?php

declare(strict_types=1);

namespace App\Modules\Product\Domain\ValueObject;

class ProductName
{
    private string $value;
    public function __construct(string $value)
    {
        if (empty($value)) {
            throw new \DomainException('Product name cannot be empty');
        }
        if (strlen($value) < 3) {
            throw new \DomainException('Product name must be at least 3 characters long');
        }
        if (strlen($value) > 50) {
            throw new \DomainException('Product name cannot be longer than 50 characters');
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}
