<?php

namespace App\Models\Shop;

use App\Models\Currency;
use App\Models\Role;
use App\Models\Timezone;
use App\Models\User;
use App\Services\Helpers\ModelHelper;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Shop extends Model
{
    use HasFactory;

    public function statuses(): HasMany
    {
        return $this->hasMany(OrderStatus::class, 'shop_id', 'id')->orWhere('shop_id', 0);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'shop_id', 'id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'shop_id', 'id');
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'shop_id', 'id');
    }

    public function tariff(): HasOne
    {
        return $this->hasOne(Tariff::class, 'id', 'tariff_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'shop_user', 'shop_id', 'user_id')->withPivot(['expired_at', 'active']);
    }

    public function timezone(): BelongsTo
    {
        return $this->belongsTo(Timezone::class, 'timezone_id', 'id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'shop_id', 'id');
    }

    public function sources(): HasMany
    {
        return $this->hasMany(OrderSource::class)->orWhere('shop_id', 0);
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'shop_id', 'id');
    }

    public function reasons(): HasMany
    {
        return $this->HasMany(OrderLostReasons::class)->orWhere('shop_id', 0);
    }

    public function categories(): HasMany
    {
        return $this->HasMany(Category::class);
    }

    public function paymentMethods(): HasMany
    {
        return $this->HasMany(PaymentMethod::class)->orWhere('shop_id', 0);
    }

    public function paymentProviders(): HasMany
    {
        return $this->HasMany(PaymentProvider::class)->orWhere('shop_id', 0);
    }

    public function paymentStatuses(): HasMany
    {
        return $this->HasMany(PaymentStatus::class)->orWhere('shop_id', 0);
    }


    /**
     * Получает статусы с формы в настройках заказов,
     * переопределяет order (очередность)
     * добавляет новые статусы если есть
     *
     * @param array $statuses
     * @param int $order очередность первого статуса (100 =+ 10)
     * @return void
     * @throws Exception
     */
    public function setStatuses(array $statuses, int $order = 100)
    {
        $this
            ->statuses()
            ->where('is_system', false)
            ->get()
            ->each(function ($item, $key) use ($statuses, $order) {

                try {
                    if (array_keys(
                            array_combine(
                                array_keys($statuses), array_column($statuses, 'id')
                            ), $item->id) == null) {

                        $item->delete();
                    }
                } catch (\Throwable $exception) {}
            });

        foreach ($statuses as $status) {

            $this
                ->status()
                ->updateOrCreate(['id' => $status['id'] ?? null],
                    [
                        'status_id' => $status['status_id'] ?? ModelHelper::generateId(OrderStatus::class, 'status_id'),
                        'name'      => $status['name'],
                        'is_system' => false,
                        'order' => $order,
                        'type'  => 'work',
                    ]);

            $order += 10;
        }
    }
}
