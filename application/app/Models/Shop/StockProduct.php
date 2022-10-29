<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockProduct extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'shop_stock_product';

    protected $fillable = [
        'product_id',
        'stock_id',
        'count',
    ];
}
