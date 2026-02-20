<?php

declare(strict_types=1);

namespace App\Modules\Product\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Product\Application\UseCase\Interface\IProductUpdateService;
use App\Modules\Product\Http\Request\ProductUpdateRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProductUpdateController extends Controller
{
    public function __construct(private IProductUpdateService $productUpdateService)
    {
    }
    public function execute(
        string $uuid,
        ProductUpdateRequest $request
    ): JsonResponse {
        $dto = $request->validatedDto();
        $data = $this->productUpdateService->execute($uuid, $dto);
        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $data,
        ]);
    }
}
