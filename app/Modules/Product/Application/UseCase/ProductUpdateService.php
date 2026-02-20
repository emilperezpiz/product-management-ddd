<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\UseCase;

use App\Modules\Product\Application\DTO\ProductDTO;
use App\Modules\Product\Application\UseCase\Interface\IProductUpdateService;
use App\Modules\Product\Domain\Entity\Product;
use App\Modules\Product\Domain\IRepository\IProductRepository;
use App\Modules\Product\Domain\ValueObject\ProductName;
use App\Modules\Product\Domain\ValueObject\ProductPrice;
use Illuminate\Support\Facades\Redis;

class ProductUpdateService implements IProductUpdateService
{
    public function __construct(
        private IProductRepository $productRepository
    ) {
    }
    public function execute(
        string $uuid,
        ProductDTO $dto
    ): ProductDTO {
        $product = $this->productRepository->getByUuid($uuid);
        if (!$product) {
            throw new \InvalidArgumentException("Product with UUID {$uuid} not found.");
        }
        $redisKey = "product:{$uuid}";
        Redis::del($redisKey);
        $productModel = $this->productRepository->update(new Product(
            uuid: $uuid,
            sku: $dto->sku,
            name: new ProductName($dto->name),
            description: $dto->description,
            price: new ProductPrice((float) $dto->price),
            category: $dto->category,
            status: $dto->status,
            imagePath: $dto->imagePath,
        ));
        return ProductDTO::from([
            'uuid' => $productModel->uuid(),
            'sku' => $productModel->sku(),
            'name' => $productModel->name()->value(),
            'description' => $productModel->description(),
            'price' => $productModel->price()->value(),
            'category' => $productModel->category(),
            'status' => $productModel->status(),
            'imagePath' => $productModel->imagePath(),
        ]);
    }
}
