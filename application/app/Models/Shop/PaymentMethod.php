<?php

namespace App\Models\Shop;

use App\Services\CacheService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'shop_payment_methods';

    protected $fillable = [
        'name',
        'method_id',
        'is_system',
        'shop_id',
    ];

    public static function cacheAll()
    {
        $shop = CacheService::getAccount();

        $collections = Cache::get('payment_methods_shop_'.$shop->id);

        if (!$collections) {

            $collections = $shop->paymentMethods;

            Cache::put('payment_methods_shop_'.$shop->id, $collections);
        }

        return $collections;
    }
}
