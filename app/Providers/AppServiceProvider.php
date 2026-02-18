<?php

namespace App\Providers;

use App\Modules\Product\Application\UseCase\Interface\IProductCreateService;
use App\Modules\Product\Application\UseCase\Interface\IProductDetailService;
use App\Modules\Product\Application\UseCase\Interface\IProductListService;
use App\Modules\Product\Application\UseCase\Interface\IProductRemoveService;
use App\Modules\Product\Application\UseCase\ProductCreateService;
use App\Modules\Product\Application\UseCase\ProductDetailService;
use App\Modules\Product\Application\UseCase\ProductListService;
use App\Modules\Product\Application\UseCase\ProductRemoveService;
use App\Modules\Product\Domain\IRepository\IProductRepository;
use App\Modules\Product\Infraestructure\Repository\ProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(
            IProductListService::class,
            ProductListService::class
        );
        $this->app->bind(
            IProductCreateService::class,
            ProductCreateService::class
        );
        $this->app->bind(
            IProductDetailService::class,
            ProductDetailService::class
        );
        $this->app->bind(
            IProductRemoveService::class,
            ProductRemoveService::class
        );
        $this->app->bind(
            IProductRepository::class,
            ProductRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
