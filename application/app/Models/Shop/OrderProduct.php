<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProduct extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'shop_order_products';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'sort',
        'shop_product_id',
        'shop_order_id',
        'qty',
        'unit_price',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'shop_product_id', 'id', );//'shop_products');
    }
}
