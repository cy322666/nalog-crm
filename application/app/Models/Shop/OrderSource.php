<?php

namespace App\Models\Shop;

use App\Services\CacheService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class OrderSource extends Model
{
    use HasFactory;

    protected $table = 'shop_order_sources';

    protected $fillable = [
        'name',
        'source_id',
        'shop_id',
        'is_system',
    ];

    public static function cacheAll()
    {
        $shop = CacheService::getAccount();

        $collections = Cache::get('order_sources_'.$shop->id);

        if (!$collections) {

            $collections = $shop->sources;

            Cache::put('order_sources_'.$shop->id, $collections);
        }

        return $collections;
    }
}
