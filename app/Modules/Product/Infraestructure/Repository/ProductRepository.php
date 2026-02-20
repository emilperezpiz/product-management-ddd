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
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

final class ProductRepository implements IProductRepository
{
    private const ITEM_PER_PAGE = 10;
    private const COLUMNS = ['sku', 'name', 'description'];
    private ProductModel $model;
    private Client $elasticsearch;
    public function __construct(
    ) {
        $this->model = new ProductModel();
        $this->elasticsearch = ClientBuilder::create()
            ->setHosts(['http://elasticsearch:9200'])
            ->build();
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
            status: $row->status,
            imagePath: $row->imagePath ?? null
        );
    }

    public function search(ProductListFilterDTO $filter): array
    {
        $limit = $filter->limit ?? self::ITEM_PER_PAGE;
        $from = ($filter->page - 1) * $limit;
        $sortField = $filter->sort;
        $order = in_array($filter->orderBy, ['asc', 'desc']) ? $filter->orderBy : 'desc';
        !in_array($sortField, self::COLUMNS) ?: $sortField = $sortField . '.keyword';
        $params = [
            'index' => 'products',
            'body' => [
                'from' => $from,
                'size' => $limit,
                'query' => [
                    'bool' => [
                        'must' => [],
                        'filter' => []
                    ]
                ]
            ]
        ];
        !in_array($sortField, ['created_at', 'price']) ?: $params['body']['sort'] = [
            [$sortField => ['order' => $order]]
        ];
        if ($filter->search) {
            $params['body']['query']['bool']['must'][] = [
                'multi_match' => [
                    'query' => $filter->search,
                    'fields' => ['name^3', 'description']
                ]
            ];
        } else {
            $params['body']['query']['bool']['must'][] = ['match_all' => (object) []];
        }
        !$filter->category ?: $params['body']['query']['bool']['filter'][] = [
            'term' => ['category.keyword' => $filter->category]
        ];
        if ($filter->status && in_array($filter->status, ['active', 'inactive'])) {
            $params['body']['query']['bool']['filter'][] = [
                'term' => ['status' => $filter->status] // status ya suele ser keyword
            ];
        }
        if (
            $filter->minPrice ||
            $filter->maxPrice
        ) {
            $range = [];
            if ($filter->minPrice)
                $range['gte'] = (float) $filter->minPrice;
            if ($filter->maxPrice)
                $range['lte'] = (float) $filter->maxPrice;

            $params['body']['query']['bool']['filter'][] = [
                'range' => ['price' => $range]
            ];
        }

        try {
            $response = $this->elasticsearch->search($params);
        } catch (\Throwable $e) {
            return [];
        }

        return array_map(function ($hit) {
            $data = (object) $hit['_source'];
            if (!isset($data->uuid)) {
                $data->uuid = $hit['_id'];
            }
            return $this->mapToDomain($data);
        }, $response['hits']['hits']);
    }

    /**
     * @return array<ProductModel>
     * */
    public function list(ProductListFilterDTO $filter): array
    {
        $limit = $filter->limit ?? self::ITEM_PER_PAGE;
        $offset = ($filter->page - 1) * $filter->limit;
        $qb = $this->qb()
            ->when($filter->sku, function (QueryBuilder $qb) use ($filter) {
                $qb->where("sku", $filter->sku);
            })
            ->when($filter->search, function (QueryBuilder $qb) use ($filter) {
                $qb->where("name", "like", "%{$filter->search}%");
            })
            ->when($filter->category, function (QueryBuilder $qb) use ($filter) {
                $qb->where("category", $filter->category);
            })
            ->where('deleted_at', null)
            ->orderBy(
                in_array($filter->sort, self::COLUMNS) ? $filter->sort : 'created_at',
                in_array($filter->orderBy, ['asc', 'desc']) ? $filter->orderBy : 'desc',
            )
            ->offset($offset)
            ->limit($limit);

        return $qb->get()->map(function ($row): Product {
            return $this->mapToDomain($row);
        })->toArray();
    }
    public function create(Product $product): Product
    {
        DB::transaction(function () use ($product): void {
            $this->model::create([
                'uuid' => $product->uuid(),
                'sku' => $product->sku(),
                'name' => $product->name()->value(),
                'description' => $product->description(),
                'price' => $product->price()->value(),
                'category' => $product->category(),
                'status' => $product->status(),
                'imagePath' => $product->imagePath(),
            ]);

            try {
                $this->elasticsearch->index([
                    'index' => 'products',
                    'id' => $product->uuid(),
                    'body' => [
                        'uuid' => $product->uuid(),
                        'sku' => $product->sku(),
                        'name' => $product->name()->value(),
                        'description' => $product->description(),
                        'price' => $product->price()->value(),
                        'category' => $product->category(),
                        'status' => $product->status(),
                        'imagePath' => $product->imagePath(),
                    ]
                ]);
            } catch (\Throwable $e) {
                throw $e;
            }
        });
        return $product;
    }

    public function update(Product $product): Product
    {
        DB::transaction(function () use ($product): void {
            $this->model::where('uuid', $product->uuid())
                ->first()
                ->update([
                    'sku' => $product->sku(),
                    'name' => $product->name()->value(),
                    'description' => $product->description(),
                    'price' => $product->price()->value(),
                    'category' => $product->category(),
                    'status' => $product->status(),
                    'imagePath' => $product->imagePath(),
                ]);
            try {
                $this->elasticsearch->index([
                    'index' => 'products',
                    'id' => $product->uuid(),
                    'body' => [
                        'uuid' => $product->uuid(),
                        'sku' => $product->sku(),
                        'name' => $product->name()->value(),
                        'description' => $product->description(),
                        'price' => (float) $product->price()->value(),
                        'category' => $product->category(),
                        'status' => $product->status(),
                        'imagePath' => $product->imagePath(),
                    ]
                ]);
            } catch (\Throwable $e) {
                throw $e;
            }
        });

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
        DB::transaction(function () use ($product): void {
            $this->qb()
                ->where('uuid', $product->uuid())
                ->update(['deleted_at' => now()]);

            try {
                $this->elasticsearch->delete([
                    'index' => 'products',
                    'id' => $product->uuid()
                ]);
            } catch (\Throwable $e) {
                throw $e;
            }
        });

    }
}
