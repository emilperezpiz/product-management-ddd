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

        try {
            $data = $this->productListService->execute($filter);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Products retrieved successfully',
            'data' => $data,
        ]);
    }
}
