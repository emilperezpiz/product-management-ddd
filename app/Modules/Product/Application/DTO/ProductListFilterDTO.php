<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\DTO;

use App\Modules\Product\Application\DTO\BaseDTO;

final class ProductListFilterDTO extends BaseDTO
{
    public int $page = 1;
    public int $limit = 10;
    public string $orderBy = "desc";
    public string $sort = "created_at";
    public ?string $sku = null;
    public ?string $search = null;
    public ?string $category = null;
    public ?string $status = null;
    public ?float $minPrice = null;
    public ?float $maxPrice = null;
}
