<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const TYPE = 5;

    /**
     * @var string
     */
    protected $table = 'shop_products';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'barcode',
        'description',
        'qty',
        'security_stock',
        'featured',
        'is_visible',
        'old_price',
        'price',
        'cost',
        'type',
        'backorder',
        'requires_shipping',
        'published_at',
        'seo_title',
        'seo_description',
        'weight_value',
        'weight_unit',
        'height_value',
        'height_unit',
        'width_value',
        'width_unit',
        'depth_value',
        'depth_unit',
        'volume_value',
        'volume_unit',
        'product_id',
        'shop_id',
        'creator_id',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'featured'   => 'boolean',
        'is_visible' => 'boolean',
        'backorder'  => 'boolean',
        'requires_shipping' => 'boolean',
        'published_at'      => 'date',
    ];

    public function stocks(): BelongsToMany
    {
        return $this->belongsToMany(Stock::class, 'shop_stock_product', 'product_id', 'stock_id');
    }

//    public function brand(): BelongsTo
//    {
//        return $this->belongsTo(Brand::class, 'shop_brand_id');
//    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'shop_category_product',  'shop_product_id', 'shop_category_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'shop_order_product', 'shop_product_id', 'shop_order_id')->withPivot('count', 'unit_price');
    }
}
