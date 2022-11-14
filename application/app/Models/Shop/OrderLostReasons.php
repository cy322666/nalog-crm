<?php

namespace App\Models\Shop;

use App\Services\CacheService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class OrderLostReasons extends Model
{
    use HasFactory;

    protected $table = 'shop_order_lost_reasons';

    protected $fillable = [

    ];

    public static function cacheAll()
    {
        $shop = CacheService::getAccount();

        $collections = Cache::get('order_reasons_'.$shop->id);

        if (!$collections) {

            $collections = $shop->reasons;

            Cache::put('order_reasons_'.$shop->id, $collections);
        }

        return $collections;
    }
}
