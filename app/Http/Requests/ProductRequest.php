<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|max:50',
            'is_active' => 'sometimes|boolean',
            'image' => 'nullable|image|max:2048'
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $product = $this->route('product');
            $rules['name'] .= '|unique:products,name,' . $product->id;
            $rules['sku'] .= '|unique:products,sku,' . $product->id;
        } else {
            $rules['name'] .= '|unique:products,name';
            $rules['sku'] .= '|unique:products,sku';
        }

        return $rules;
    }
}
