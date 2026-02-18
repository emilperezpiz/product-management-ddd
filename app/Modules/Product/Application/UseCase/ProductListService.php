<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\UseCase;

use App\Modules\Product\Application\DTO\ProductDTO;
use App\Modules\Product\Application\DTO\ProductListFilterDTO;
use App\Modules\Product\Application\UseCase\Interface\IProductListService;
use App\Modules\Product\Domain\Entity\Product;
use App\Modules\Product\Domain\IRepository\IProductRepository;

class ProductListService implements IProductListService
{
    public function __construct(
        private IProductRepository $productRepository
    ) {
    }

    /**
     * @return array<ProductDTO>
     * */
    public function execute(ProductListFilterDTO $filter): array
    {
        $result = $this->productRepository->list($filter);
        return array_map(function (Product $product) {
            return ProductDTO::from([
                'uuid' => $product->uuid(),
                'sku' => $product->sku(),
                'name' => $product->name()->value(),
                'description' => $product->description(),
                'price' => $product->price()->value(),
                'category' => $product->category(),
                'status' => $product->status()
            ]);
        }, $result);
    }
}
