<?php

namespace App\Models\Shop;

use App\Services\CacheService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PaymentProvider extends Model
{
    use HasFactory;

    protected $table = 'shop_payment_providers';

    public static function cacheAll()
    {
        $shop = CacheService::getAccount();

        $collections = Cache::get('payment_providers_shop_'.$shop->id);

        if (!$collections) {

            $collections = $shop->paymentProviders;

            Cache::put('payment_providers_shop_'.$shop->id, $collections);
        }

        return $collections;
    }
}
