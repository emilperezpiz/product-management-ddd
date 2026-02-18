<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\DTO;

use App\Modules\Product\Application\DTO\BaseDTO;

final class ProductListFilterDTO extends BaseDTO
{
    public int $page = 1;
    public int $limit = 10;
    public ?string $sku = null;
    public ?string $name = null;
}
