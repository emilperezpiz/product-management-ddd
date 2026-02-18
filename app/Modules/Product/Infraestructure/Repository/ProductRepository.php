<?php

declare(strict_types=1);

namespace App\Modules\Product\Infraestructure\Repository;

use App\Modules\Product\Application\DTO\ProductListFilterDTO;
use App\Modules\Product\Domain\Entity\Product;
use App\Modules\Product\Domain\IRepository\IProductRepository;
use App\Modules\Product\Domain\ValueObject\ProductName;
use App\Modules\Product\Domain\ValueObject\ProductPrice;
use App\Modules\Product\Infraestructure\Model\Product as ProductModel;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class ProductRepository implements IProductRepository
{
    private ProductModel $model;
    public function __construct(
    ) {
        $this->model = new ProductModel();
    }
    private function qb(): QueryBuilder
    {
        return DB::table($this->model->getTable());
    }

    private function mapToDomain(object $row): Product
    {
        return new Product(
            uuid: $row->uuid,
            sku: $row->sku,
            name: new ProductName($row->name),
            description: $row->description,
            price: new ProductPrice((float) $row->price),
            category: $row->category,
            status: $row->status
        );
    }

    /**
     * @return array<ProductModel>
     * */
    public function list(ProductListFilterDTO $filter): array
    {
        $qb = $this->qb()
            ->when($filter->sku, function (QueryBuilder $qb) use ($filter) {
                $qb->where("sku", $filter->sku);
            })
            ->when($filter->name, function (QueryBuilder $qb) use ($filter) {
                $qb->where("name", "like", "%{$filter->name}%");
            })
            ->where('deleted_at', null)
            ->orderBy('created_at', 'desc')
            ->offset(($filter->page - 1) * $filter->limit)
            ->limit($filter->limit);

        return $qb->get()->map(function ($row) {
            return $this->mapToDomain($row);
        })->toArray();
    }
    public function create(Product $product): Product
    {
        $this->model::create([
            'uuid' => $product->uuid(),
            'sku' => $product->sku(),
            'name' => $product->name()->value(),
            'description' => $product->description(),
            'price' => $product->price()->value(),
            'category' => $product->category(),
            'status' => $product->status()
        ]);

        return $product;
    }

    public function update(Product $product): Product
    {
        $this->model::where('uuid', $product->uuid())
            ->first()
            ->update([
                'sku' => $product->sku(),
                'name' => $product->name()->value(),
                'description' => $product->description(),
                'price' => $product->price()->value(),
                'category' => $product->category(),
                'status' => $product->status()
            ]);

        return $product;
    }

    public function getByUuid(string $uuid): ?Product
    {
        $qb = $this->qb()->where("uuid", $uuid);
        $row = $qb->first();

        if (!$row) {
            return null;
        }

        return $this->mapToDomain($row);
    }

    public function remove(Product $product): void
    {
        $this->qb()
            ->where('uuid', $product->uuid())
            ->update(['deleted_at' => now()]);
    }
}
