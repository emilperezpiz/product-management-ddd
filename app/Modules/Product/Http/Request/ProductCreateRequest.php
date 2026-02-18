<?php

declare(strict_types=1);

namespace App\Modules\Product\Http\Request;

use App\Modules\Product\Application\DTO\ProductCreateDTO;
use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sku' => ['required', 'string', 'max:20', 'unique:products,sku'],
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'description' => ['nullable', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:25'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    public function validatedDto(): ProductCreateDTO
    {
        $validated = parent::validated();
        return ProductCreateDTO::from($validated);
    }
}
