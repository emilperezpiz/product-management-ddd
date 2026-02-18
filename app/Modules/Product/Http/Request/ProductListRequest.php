<?php

declare(strict_types=1);

namespace App\Modules\Product\Http\Request;

use App\Modules\Product\Application\DTO\ProductListFilterDTO;
use Illuminate\Foundation\Http\FormRequest;

class ProductListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            '*' => 'nullable',
        ];
    }

    public function validatedDto(): ProductListFilterDTO
    {
        $validated = parent::validated();
        return ProductListFilterDTO::from($validated);
    }
}
