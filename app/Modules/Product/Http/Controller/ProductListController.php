<?php

declare(strict_types=1);

namespace App\Modules\Product\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Product\Application\UseCase\Interface\IProductListService;
use App\Modules\Product\Http\Request\ProductListRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProductListController extends Controller
{
    public function __construct(private IProductListService $productListService)
    {
    }
    public function execute(ProductListRequest $request): JsonResponse
    {
        $filter = $request->validatedDto();
        $data = $this->productListService->execute($filter);
        return response()->json([
            'message' => 'Products retrieved successfully',
            'data' => $data,
        ]);
    }
}
