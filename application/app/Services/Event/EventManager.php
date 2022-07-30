<?php

namespace App\Services\Event;

abstract class EventManager
{
    public const CREATED_TYPE = 1;
    public const UPDATED_TYPE = 2;
    public const DELETED_TYPE = 3;

    public const CUSTOMER_UPDATED_TEXT = 'Клиент обновлен';
    public const CUSTOMER_CREATED_TEXT = 'Клиент создан';
    public const CUSTOMER_DELETED_TEXT = 'Клиент удален';

    public const ORDER_UPDATED_TEXT = 'Заказ обновлен';
    public const ORDER_CREATED_TEXT = 'Заказ создан';
    public const ORDER_DELETED_TEXT = 'Заказ удален';

    public static function clientUpdated(): array
    {
        return [
            'title' => self::CUSTOMER_UPDATED_TEXT,
            'type'  => self::UPDATED_TYPE,
        ];
    }

    public static function clientCreated(): array
    {
        return [
            'title' => self::CUSTOMER_CREATED_TEXT,
            'type'  => self::CREATED_TYPE,
        ];
    }

    public static function orderUpdated(): array
    {
        return [
            'title' => self::ORDER_UPDATED_TEXT,
            'type'  => self::UPDATED_TYPE,
        ];
    }

    public static function orderCreated(): array
    {
        return [
            'title' => self::ORDER_CREATED_TEXT,
            'type'  => self::CREATED_TYPE,
        ];
    }

    public static function orderDeleted(): array
    {
        return [
            'title' => self::ORDER_DELETED_TEXT,
            'type'  => self::DELETED_TYPE,
        ];
    }

    public static function clientDeleted(): array
    {
        return [
            'title' => self::CUSTOMER_DELETED_TEXT,
            'type'  => self::DELETED_TYPE,
        ];
    }
}
