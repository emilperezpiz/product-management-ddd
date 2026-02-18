<?php

declare(strict_types=1);

use Core\Infraestructure\Http\Controller\User\UserCreateController;
use Core\Infraestructure\Http\Controller\User\UserDetailController;
use Core\Infraestructure\Http\Controller\User\UserEditController;
use Core\Infraestructure\Http\Controller\User\UserListController;
use Core\Infraestructure\Http\Controller\User\UserRemoveController;
use Illuminate\Support\Facades\Route;


Route::prefix('user')
    ->middleware(['auth:api',/*'api', 'JWT', 'cors', 'localization'*/])
    ->group(function () {
        Route::get('/', [UserListController::class, 'execute'])->name('user.list');
        Route::post('/', [UserCreateController::class, 'execute'])->name('user.create');
        Route::get('/{uuid}', [UserDetailController::class, 'execute'])->name('user.detail');
        Route::delete('/{uuid}', [UserRemoveController::class, 'execute'])->name('user.delete');
        Route::put('/{uuid}', [UserEditController::class, 'execute'])->name('user.edit');
    });
