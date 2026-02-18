<?php

declare(strict_types=1);

namespace App\Modules\Product\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Product\Application\UseCase\Interface\IProductCreateService;
use App\Modules\Product\Http\Request\ProductCreateRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProductCreateController extends Controller
{
    public function __construct(private IProductCreateService $productCreateService)
    {
    }
    public function execute(ProductCreateRequest $request): JsonResponse
    {
        $dto = $request->validatedDto();

        try {
            $data = $this->productCreateService->execute($dto);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $data,
        ], Response::HTTP_CREATED);
    }
}
