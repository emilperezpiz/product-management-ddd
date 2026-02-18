<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\UseCase;

use App\Modules\Product\Application\DTO\ProductDTO;
use App\Modules\Product\Application\UseCase\Interface\IProductDetailService;
use App\Modules\Product\Domain\IRepository\IProductRepository;

class ProductDetailService implements IProductDetailService
{
    public function __construct(
        private IProductRepository $productRepository
    ) {
    }

    /**
     * @return array<ProductDTO>
     * */
    public function execute(string $uuid): ProductDTO
    {
        $product = $this->productRepository->getByUuid($uuid);

        if (!$product) {
            throw new \InvalidArgumentException("Product with UUID {$uuid} not found.");
        }

        return ProductDTO::from([
            'uuid' => $product->uuid(),
            'sku' => $product->sku(),
            'name' => $product->name()->value(),
            'description' => $product->description(),
            'price' => $product->price()->value(),
            'category' => $product->category(),
            'status' => $product->status()
        ]);
    }
}
