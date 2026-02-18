<?php

declare(strict_types=1);

use App\Modules\Product\Http\Controller\ProductCreateController;
use App\Modules\Product\Http\Controller\ProductDetailController;
use App\Modules\Product\Http\Controller\ProductListController;
use App\Modules\Product\Http\Controller\ProductRemoveController;
use App\Modules\Product\Http\Controller\ProductUpdateController;
use Core\Infraestructure\Http\Controller\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizedAccessTokenController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;
use Nette\Utils\Json;
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
    return ['message' => 'Pong desde la API!'];
});

Route::prefix('product')->group(function () {
    Route::get('/', [ProductListController::class, 'execute'])->name('product.list');
    Route::post('/', [ProductCreateController::class, 'execute'])->name('product.create');
    Route::get('/{uuid}', [ProductDetailController::class, 'execute'])->name('product.details');
    Route::put('/{uuid}', [ProductUpdateController::class, 'execute'])->name('product.update');
    Route::delete('/{uuid}', [ProductRemoveController::class, 'execute'])->name('product.remove');
});
