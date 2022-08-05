<?php

namespace App\Services\Helpers;

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
}
