<?php

declare(strict_types=1);

namespace App\Modules\Product\Http\Controller;

use App\Http\Controllers\Controller;
use App\Modules\Product\Application\UseCase\Interface\IProductRemoveService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ProductRemoveController extends Controller
{
    public function __construct(private IProductRemoveService $productRemoveService)
    {
    }
    public function execute(string $uuid): JsonResponse
    {
        try {
            $this->productRemoveService->execute($uuid);
        } catch (\Throwable $e) {
            return response()->json([
                'data' => [],
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'message' => 'Product removed successfully',
        ], Response::HTTP_NO_CONTENT);
    }
}
