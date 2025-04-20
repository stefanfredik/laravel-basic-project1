<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class ProductImports implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $category = Category::firstOrCreate(
            ['name' => $row['category']],
            [
                'slug' => Str::slug($row['category']),
                'description' => null
            ]
        );


        return new Product([
            'name' => $row('name'),
            'slug' => Str::slug($row['name']),
            'description' => $row['description'] ?? null,
            'price' => $row['price'],
            'stock_quantity' => $row['stock_quantity'],
            'sku' => $row['sku'],
            'category_id' => $category->id,
            'is_active' => $row['is_active']
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'sku' => 'required|string|max:50|unique:products,sku',
            'is_active' => 'nullable|boolean'
        ];
    }
}
