<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSources extends Model
{
    use HasFactory;

    protected $table = 'shop_order_sources';

    protected $fillable = [
        'name',
        'source_id',
        'shop_id',
        'is_system',
    ];
}
