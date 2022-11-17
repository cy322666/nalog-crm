<?php

namespace App\Models\Shop;

use App\Services\CacheService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PaymentStatus extends Model
{
    use HasFactory;

    protected $table = 'shop_payment_statuses';

    public const NEW_STATUS_ID = 201;
    public const WIN_STATUS_ID = 202;
    public const LOST_STATUS_ID = 203;

    public const WIN_STATUS_NAME = 'Оплачен';
    public const LOST_STATUS_NAME = 'Отменен';
    public const NEW_STATUS_NAME = 'Новый';

    protected $fillable = [
        'name',
        'status_id',
        'type',
        'is_system',
        'shop_id',
    ];

    public static function cacheAll()
    {
        $shop = CacheService::getAccount();

//        $collections = Cache::get('payment_statuses_shop_'.$shop->id);
//
//        if (!$collections || $collections = []) {
//TODO пофиксить возвращает пустоту
            $collections = $shop->paymentStatuses;

//            Cache::put('payment_statuses_shop_'.$shop->id, $collections);
//        }

        return $collections;
    }
}
