<?php

namespace App\Models\Shop;

use App\Models\Currency;
use App\Models\Timezone;
use App\Models\User;
use App\Services\Helpers\ModelHelper;
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
        return $this->hasMany(OrderStatus::class, 'shop_id', 'id')
            ->orWhere('shop_id', 0);
    }

    public function status()
    {
        return $this->hasOne(OrderStatus::class, 'shop_id', 'id');
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
        return $this->belongsToMany(OrderSource::class)->orWhere('shop_id', 0);
    }

    public function reasons(): HasMany
    {
        return $this->HasMany(OrderLostReasons::class)->orWhere('shop_id', 0);
    }

    /**
     * Получает статусы с формы в настройках заказов,
     * переопределяет order (очередность)
     * добавляет новые статусы если есть
     *
     * @param array $statuses
     * @param int $order очередность первого статуса (100 =+ 10)
     * @return void
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
