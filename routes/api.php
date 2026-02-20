<?php

declare(strict_types=1);

use App\Modules\Product\Http\Controller\ProductCreateController;
use App\Modules\Product\Http\Controller\ProductDetailController;
use App\Modules\Product\Http\Controller\ProductListController;
use App\Modules\Product\Http\Controller\ProductRemoveController;
use App\Modules\Product\Http\Controller\ProductSearchController;
use App\Modules\Product\Http\Controller\ProductUpdateController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function (): JsonResponse {
    return response()->json([
        'error' => 'É proibido o acesso direto ao endpoint raiz.',
    ], Response::HTTP_FORBIDDEN);
});
Route::get('/ping', function (): array {
    \Illuminate\Support\Facades\Redis::setex('ping', 60, 'Pong desde la API!');
    return ['message' => \Illuminate\Support\Facades\Redis::get('ping')];

});
Route::prefix('products')->group(function () {
    Route::get('/', [ProductListController::class, 'execute'])->name('product.list');
    Route::post('/', [ProductCreateController::class, 'execute'])->name('product.create');
    Route::get('/{uuid}', [ProductDetailController::class, 'execute'])->name('product.details');
    Route::put('/{uuid}', [ProductUpdateController::class, 'execute'])->name('product.update');
    Route::delete('/{uuid}', [ProductRemoveController::class, 'execute'])->name('product.remove');
});
Route::get('search/products', [ProductSearchController::class, 'execute'])->name('product.search');

