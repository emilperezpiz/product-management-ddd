<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\UseCase;

use App\Modules\Product\Application\DTO\ProductDTO;
use App\Modules\Product\Application\UseCase\Interface\IProductRemoveService;
use App\Modules\Product\Domain\IRepository\IProductRepository;

class ProductRemoveService implements IProductRemoveService
{
    public function __construct(
        private IProductRepository $productRepository
    ) {
    }

    /**
     * @return array<ProductDTO>
     * */
    public function execute(string $uuid): void
    {
        $product = $this->productRepository->getByUuid($uuid);

        if (!$product) {
            throw new \InvalidArgumentException("Product with UUID {$uuid} not found.");
        }

        $this->productRepository->remove($product);
    }
}
