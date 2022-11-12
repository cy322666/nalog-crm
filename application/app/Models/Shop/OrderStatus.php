<?php

namespace App\Models\Shop;

use App\Services\CacheService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class OrderStatus extends Model
{
    use HasFactory;

    protected $table = 'shop_order_statuses';

    public const NEW_STATUS_ID = 101;
    public const WIN_STATUS_ID = 102;
    public const LOST_STATUS_ID = 103;

    public const WIN_STATUS_NAME = 'Выиграно';
    public const LOST_STATUS_NAME = 'Потеряно';
    public const NEW_STATUS_NAME = 'Новый заказ';

    protected $fillable = [
        'status_id',
        'is_system',
        'name',
        'type',
        'order',
    ];

    public static function cacheAll()
    {
        $shop = CacheService::getAccount();

        $collections = Cache::get('order_statuses_shop_'.$shop->id);

        if (!$collections) {

            $collections = $shop->sources;

            Cache::put('order_statuses_shop_'.$shop->id, $collections);
        }

        return $collections;
    }
}
