<?php

namespace App\Models\Shop;

use App\Models\User;
use App\Services\CacheService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Order extends Model
{
    use HasFactory;

    public const TYPE = 1;

    protected $table = 'shop_orders';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'status_id',
        'lost_reasons_id',
        'source_id',
        'shipping_price',
        'shipping_method',
        'description',
        'responsible_id',
        'closed',
        'price',
        'shop_id',
        'pay_parts',
        'creator_id',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

//    public function address(): MorphOne
//    {
//        return $this->morphOne(OrderAddress::class, 'addressable');
//    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'shop_customer_id');
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(OrderSource::class, 'source_id');
    }

    public function reason(): BelongsTo
    {
        return $this->belongsTo(OrderLostReasons::class, 'lost_reasons_id');
    }

    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id', 'id');
    }

    public function statuses(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'status_id')
            ->orWhere('shop_id', 0);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'shop_order_product', 'shop_order_id', 'shop_product_id')->withPivot('count', 'unit_price');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

//    public function tasks(): HasMany
//    {
//        return $this->hasMany(Task::class, 'model_id', 'id')
//            ->where('model_type', $this::class);
//    }

    public function comments()
    {

    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'shop_order_service', 'order_id', 'service_id');
    }

    public function events()
    {

    }

    public function isLost(): bool
    {
        return (bool)$this->status?->status_id == 103 ?? false;
    }

    public function isActive(): bool
    {
        return (bool)$this->closed == false;
    }
}
