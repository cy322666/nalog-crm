<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Stock extends Model
{
    use HasFactory;

    protected $fillable  = [
        'name',
        'shop_id',
        'stock_id',
        'parent_stock_id',
    ];

    protected $table = 'shop_stocks';

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'shop_stock_product', 'stock_id', 'product_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Stock::class, 'parent_stock_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Stock::class, 'parent_stock_id', 'id');
    }

    public function isChild(): bool
    {
        return (bool)$this->parent_stock_id > 0;
    }
}
