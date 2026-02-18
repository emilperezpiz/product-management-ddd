<?php

declare(strict_types=1);

namespace App\Modules\Product\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Product\Application\UseCase\Interface\IProductUpdateService;
use App\Modules\Product\Http\Request\ProductCreateRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProductUpdateController extends Controller
{
    public function __construct(private IProductUpdateService $productUpdateService)
    {
    }
    public function execute(
        string $uuid,
        ProductCreateRequest $request
    ): JsonResponse {
        $dto = $request->validatedDto();

        try {
            $data = $this->productUpdateService->execute($uuid, $dto);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $data,
        ]);
    }
}
