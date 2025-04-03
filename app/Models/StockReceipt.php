<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockReceipt extends Model
{
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(StockReceiptItem::class);
    }
}
