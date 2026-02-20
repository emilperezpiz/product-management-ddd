<?php

declare(strict_types=1);

namespace App\Modules\Product\Domain\IRepository;

use App\Modules\Product\Application\DTO\ProductListFilterDTO;
use App\Modules\Product\Domain\Entity\Product;
use App\Modules\Product\Infraestructure\Model\Product as ProductModel;

interface IProductRepository
{
    /**
     * @return array<ProductModel>
     * */
    public function list(ProductListFilterDTO $filter): array;
    public function search(ProductListFilterDTO $filter): array;
    public function create(Product $product): Product;
    public function getByUuid(string $uuid): ?Product;
    public function update(Product $product): Product;
    public function remove(Product $product): void;
}
