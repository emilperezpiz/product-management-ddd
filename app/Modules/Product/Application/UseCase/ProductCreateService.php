<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\UseCase;

use App\Modules\Product\Application\DTO\ProductCreateDTO;
use App\Modules\Product\Application\DTO\ProductDTO;
use App\Modules\Product\Application\UseCase\Interface\IProductCreateService;
use App\Modules\Product\Domain\Entity\Product;
use App\Modules\Product\Domain\IRepository\IProductRepository;
use App\Modules\Product\Domain\ValueObject\ProductName;
use App\Modules\Product\Domain\ValueObject\ProductPrice;

class ProductCreateService implements IProductCreateService
{
    public function __construct(
        private IProductRepository $productRepository
    ) {
    }
    public function execute(ProductCreateDTO $dto): ProductDTO
    {
        $productModel = $this->productRepository->create(Product::create(
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
