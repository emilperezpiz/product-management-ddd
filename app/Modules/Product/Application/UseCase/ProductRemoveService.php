<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\UseCase;

use App\Modules\Product\Application\DTO\ProductDTO;
use App\Modules\Product\Application\UseCase\Interface\IProductRemoveService;
use App\Modules\Product\Domain\IRepository\IProductRepository;
use Illuminate\Support\Facades\Redis;

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
        $redisKey = "product:{$uuid}";
        Redis::del($redisKey);
        $this->productRepository->remove($product);
    }
}
