<?php

declare(strict_types=1);

namespace App\Modules\Product\Application\UseCase\Interface;

interface IProductRemoveService
{
    public function execute(string $uuid): void;
}
