<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Category extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public const TYPE = 6;

    /**
     * @var string
     */
    protected $table = 'shop_categories';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'shop_id',
        'description',
        'category_id',
        'creator_id',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'shop_category_product', 'shop_category_id', 'shop_product_id');
    }
}
