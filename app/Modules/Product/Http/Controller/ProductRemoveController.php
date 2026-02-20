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
        $this->productRemoveService->execute($uuid);
        return response()->json([
            'message' => 'Product removed successfully',
        ], Response::HTTP_NO_CONTENT);
    }
}
