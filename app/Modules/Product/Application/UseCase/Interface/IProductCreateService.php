<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\UseCase\Interface;

use App\Modules\Product\Application\DTO\ProductCreateDTO;
use App\Modules\Product\Application\DTO\ProductDTO;

interface IProductCreateService
{
    public function execute(ProductCreateDTO $dto): ProductDTO;
}
