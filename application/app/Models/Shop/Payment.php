<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'shop_payments';

    protected $guarded = [];

    protected $fillable = [
        'shop_id',
        'order_id',
        'name',
        'amount',
        'amount_payed',
        'steps',
        'status_id',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function providers()
    {
        return $this->hasMany(PaymentProvider::class, 'id', 'payment_id')
            ->orWhere('shop_id', 0);
    }

    public function provider()
    {
        return $this->hasOne(PaymentProvider::class, 'id', 'payment_id');
    }

//    public function method()
//    {
//
//    }

    public function status()
    {

    }
}
