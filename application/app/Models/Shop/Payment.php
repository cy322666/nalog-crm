<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    public const TYPE = 4;

    protected $table = 'shop_payments';

    protected $guarded = [];

    protected $fillable = [
        'shop_id',
        'order_id',
        'name',
        'amount',
        'status_id',
        'payed',
        'payment_id',
        'method_id',
        'provider_id',
        'creator_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(PaymentProvider::class);
    }

    public function method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'method_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(PaymentStatus::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
