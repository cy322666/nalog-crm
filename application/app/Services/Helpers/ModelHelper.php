<?php

namespace App\Services\Helpers;

use App\Models\Shop\Category;
use App\Models\Shop\Comment;
use App\Models\Shop\Customer;
use App\Models\Shop\Order;
use App\Models\Shop\Payment;
use App\Models\Shop\Product;
use App\Models\Shop\Task;
use App\Services\CacheService;
use Exception;

abstract class ModelHelper
{
    /**
     * Генерит внешний id исходя из последней записи этой сущности в аккаунте + 1
     *
     * @param string $className Класс модели для которой генерим
     * @param string $column Столбец исходя из которого генерим
     * @throws Exception
     */
    public static function generateId(string $className, string $column) : int
    {
        $lastRecord =  $className::query()
            ->where('shop_id', CacheService::getAccountId())
            ->oldest($column)
            ->first();

        return $lastRecord ? $lastRecord->$column + 2 : random_int(200000, 999999);
    }

    public static function generateName(string $className, string $column) : string
    {

    }

    public static function clearPhone(?string $phone): array|string|null
    {
        $patterns = ['/[^\d,]+/', '/,,+/'];
        $replacements = [''];

        return preg_replace($patterns, $replacements, $phone);
    }

    /**
     * Отдает имя класса по его типу сущности в системе
     *
     * @param int $type
     * @return string
     */
    public static function getEntityType(int $type): string
    {
        return match ($type) {
            1 => Order::class,
            2 => Customer::class,
            3 => Task::class,
            4 => Payment::class,
            5 => Product::class,
            6 => Category::class,
            7 => Comment::class,
        };
    }
}
