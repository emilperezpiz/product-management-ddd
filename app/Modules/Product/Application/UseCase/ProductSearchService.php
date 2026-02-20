<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\UseCase;

use App\Modules\Product\Application\DTO\ProductDTO;
use App\Modules\Product\Application\DTO\ProductListFilterDTO;
use App\Modules\Product\Application\UseCase\Interface\IProductSearchService;
use App\Modules\Product\Domain\Entity\Product;
use App\Modules\Product\Domain\IRepository\IProductRepository;
use Illuminate\Support\Facades\Redis;

class ProductSearchService implements IProductSearchService
{
    private const LIMIT_PAGES_TO_CACHE = 50;
    private const REDIS_TTL_TWO_MINUTE = 120;
    public function __construct(
        private IProductRepository $productRepository
    ) {
    }

    /**
     * @return array<ProductDTO>
     * */
    public function execute(ProductListFilterDTO $filter): array
    {
        if ($filter->page <= self::LIMIT_PAGES_TO_CACHE) {
            $createRedisKey = function (ProductListFilterDTO $filter): string {
                $data = $filter->toArray();
                return json_encode(ksort($data));
            };
            $redisKey = "product:list:" . $createRedisKey($filter);
            $cachedData = Redis::get($redisKey);
            if ($cachedData) {
                return array_map(function (array $product): ProductDTO {
                    return ProductDTO::from([
                        'uuid' => $product['uuid'],
                        'sku' => $product['sku'],
                        'name' => $product['name'],
                        'description' => $product['description'],
                        'price' => $product['price'],
                        'category' => $product['category'],
                        'status' => $product['status']
                    ]);
                }, json_decode($cachedData, true));
            }
        }
        $data = $this->productRepository->search($filter);
        $dataToRedis = [];
        $result = array_map(function (Product $product) use (&$dataToRedis): ProductDTO {
            $item = ProductDTO::from([
                'uuid' => $product->uuid(),
                'sku' => $product->sku(),
                'name' => $product->name()->value(),
                'description' => $product->description(),
                'price' => $product->price()->value(),
                'category' => $product->category(),
                'status' => $product->status()
            ]);
            $dataToRedis[] = $item->toArray();
            return $item;
        }, $data);
        Redis::setex($redisKey, self::REDIS_TTL_TWO_MINUTE, json_encode($dataToRedis));
        return $result;
    }
}
