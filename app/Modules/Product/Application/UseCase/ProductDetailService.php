<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\UseCase;

use App\Modules\Product\Application\DTO\ProductDTO;
use App\Modules\Product\Application\UseCase\Interface\IProductDetailService;
use App\Modules\Product\Domain\IRepository\IProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Redis;

class ProductDetailService implements IProductDetailService
{
    private const REDIS_TTL_ONE_MINUTE = 60;
    public function __construct(
        private IProductRepository $productRepository
    ) {
    }

    /**
     * @return array<ProductDTO>
     * */
    public function execute(string $uuid): ProductDTO
    {
        $redisKey = "product:{$uuid}";
        $cachedData = Redis::get($redisKey);
        if ($cachedData) {
            return ProductDTO::from(json_decode($cachedData, true));
        }
        $product = $this->productRepository->getByUuid($uuid);
        if (!$product) {
            throw new ModelNotFoundException("Product with UUID {$uuid} not found.");
        }
        $data = ProductDTO::from([
            'uuid' => $product->uuid(),
            'sku' => $product->sku(),
            'name' => $product->name()->value(),
            'description' => $product->description(),
            'price' => $product->price()->value(),
            'category' => $product->category(),
            'status' => $product->status(),
            'imagePath' => $product->imagePath(),
        ]);
        Redis::setex($redisKey, self::REDIS_TTL_ONE_MINUTE, json_encode($data->toArray()));
        return $data;
    }
}
