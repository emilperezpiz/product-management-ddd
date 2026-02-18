<?php

declare(strict_types=1);

namespace App\Modules\Product\Domain\Entity;

use App\Modules\Product\Domain\ValueObject\ProductName;
use App\Modules\Product\Domain\ValueObject\ProductPrice;
use Illuminate\Support\Str;

class Product
{
    public function __construct(
        private ?string $uuid,
        private string $sku,
        private ProductName $name,
        private ?string $description,
        private ProductPrice $price,
        private string $category,
        private string $status
    ) {
    }

    public static function create(
        string $sku,
        ProductName $name,
        ?string $description,
        ProductPrice $price,
        string $category,
        string $status = 'active'
    ): self {
        return new self(
            uuid: (string) Str::orderedUuid(),
            sku: $sku,
            name: $name,
            description: $description,
            price: $price,
            category: $category,
            status: $status
        );
    }

    public function uuid(): ?string
    {
        return $this->uuid;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function name(): ProductName
    {
        return $this->name;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function price(): ProductPrice
    {
        return $this->price;
    }

    public function category(): string
    {
        return $this->category;
    }

    public function status(): string
    {
        return $this->status;
    }
}
