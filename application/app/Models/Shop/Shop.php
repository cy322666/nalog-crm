<?php

namespace App\Models\Shop;

use App\Models\Currency;
use App\Models\Timezone;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    use HasFactory;

    public function statuses(): HasMany
    {
        return $this->hasMany(OrderStatus::class)->orWhere('shop_id', 0);
    }

    public function tariff(): HasOne
    {
        return $this->hasOne(Tariff::class, 'id', 'tariff_id');
    }

    //TODO employee -> user
    public function employees(): HasMany
    {
        return $this->hasMany(User::class, 'id', 'employee_id');
    }

    public function timezone(): BelongsTo
    {
        return $this->belongsTo(Timezone::class, 'timezone_id', 'id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function sources(): BelongsToMany
    {
        return $this->belongsToMany(OrderSources::class)->orWhere('shop_id', 0);
    }

    public function reasons(): BelongsToMany
    {
        return $this->belongsToMany(OrderLostReasons::class)->orWhere('shop_id', 0);
    }
}
