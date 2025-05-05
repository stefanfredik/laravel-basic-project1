<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'price', 'stock_quantity', 'sku', 'category_id', 'description', 'image_path'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function stockReceiptItems()
    {
        return $this->hasMany(StockReceiptItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
