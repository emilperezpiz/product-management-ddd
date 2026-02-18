<?php

declare(strict_types=1);

namespace App\Modules\Product\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Product\Application\UseCase\Interface\IProductDetailService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProductDetailController extends Controller
{
    public function __construct(private IProductDetailService $productDetailService)
    {
    }
    public function execute(string $uuid): JsonResponse
    {
        try {
            $data = $this->productDetailService->execute($uuid);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Product retrieved successfully',
            'data' => $data,
        ]);
    }
}
