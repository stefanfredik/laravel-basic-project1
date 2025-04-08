<?php

namespace App\Exports;


use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExports implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Product::with('category')->get();
    }


    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'SKU',
            'Kategori',
            'Harga',
            'Stok',
            'Status'
        ];
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->sku,
            $product->category->name,
            $product->price,
            $product->stock_quantity,
            $product->is_active ? 'Aktif' : 'Tidak aktif'
        ];
    }
}
