<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;

    protected $table = 'shop_services';

    protected $fillable = [
        'shop_id',
        'service_id',
        'name',
        'price',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'shop_order_service', 'service_id', 'order_id');
    }
}
