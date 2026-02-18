<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\DTO;

use App\Modules\Product\Application\DTO\BaseDTO;

class ProductDTO extends BaseDTO
{
    public ?string $uuid;
    public string $sku;
    public string $name;
    public ?string $description;
    public float $price;
    public string $category;
    public string $status;
}
