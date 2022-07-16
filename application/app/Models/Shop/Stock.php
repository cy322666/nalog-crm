<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'shop_stocks';

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'shop_stock_product', 'stock_id', 'product_id');
    }
}
