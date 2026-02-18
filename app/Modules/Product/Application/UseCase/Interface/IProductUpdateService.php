<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\UseCase\Interface;

use App\Modules\Product\Application\DTO\ProductDTO;

interface IProductUpdateService
{
    public function execute(
        string $uuid,
        ProductDTO $dto
    ): ProductDTO;
}
