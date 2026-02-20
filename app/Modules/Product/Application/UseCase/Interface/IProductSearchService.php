<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\UseCase\Interface;

use App\Modules\Product\Application\DTO\ProductDTO;
use App\Modules\Product\Application\DTO\ProductListFilterDTO;

interface IProductSearchService
{
    /**
     * @return array<ProductDTO>
     * */
    public function execute(ProductListFilterDTO $filter): array;
}
