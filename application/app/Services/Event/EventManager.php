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

    public const TASK_UPDATED_TEXT = 'Задача обновлена';
    public const TASK_CREATED_TEXT = 'Задача создана';
    public const TASK_DELETED_TEXT = 'Задача удалена';

    public const CATEGORY_UPDATED_TEXT = 'Категория обновлена';
    public const CATEGORY_CREATED_TEXT = 'Категория создана';
    public const CATEGORY_DELETED_TEXT = 'Категория удалена';

    public const PRODUCT_UPDATED_TEXT = 'Товар обновлен';
    public const PRODUCT_CREATED_TEXT = 'Товар создан';
    public const PRODUCT_DELETED_TEXT = 'Товар удален';

    public const PAYMENT_UPDATED_TEXT = 'Платеж обновлен';
    public const PAYMENT_CREATED_TEXT = 'Платеж создан';
    public const PAYMENT_DELETED_TEXT = 'Платеж удален';

    public const SERVICE_UPDATED_TEXT = 'Услуга обновлена';
    public const SERVICE_CREATED_TEXT = 'Услуга создана';
    public const SERVICE_DELETED_TEXT = 'Услуга удалена';

    //client

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

    public static function clientDeleted(): array
    {
        return [
            'title' => self::CUSTOMER_DELETED_TEXT,
            'type'  => self::DELETED_TYPE,
        ];
    }

    //order

    public static function orderCreated(): array
    {
        return [
            'title' => self::ORDER_CREATED_TEXT,
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

    public static function orderDeleted(): array
    {
        return [
            'title' => self::ORDER_DELETED_TEXT,
            'type'  => self::DELETED_TYPE,
        ];
    }

    //task

    public static function taskCreated(): array
    {
        return [
            'title' => self::TASK_CREATED_TEXT,
            'type'  => self::CREATED_TYPE,
        ];
    }

    public static function taskUpdated(): array
    {
        return [
            'title' => self::TASK_UPDATED_TEXT,
            'type'  => self::UPDATED_TYPE,
        ];
    }

    public static function taskDeleted(): array
    {
        return [
            'title' => self::TASK_DELETED_TEXT,
            'type' => self::DELETED_TYPE,
        ];
    }

    //category

    public static function categoryCreated(): array
    {
        return [
            'title' => self::CATEGORY_CREATED_TEXT,
            'type'  => self::CREATED_TYPE,
        ];
    }

    public static function categoryUpdated(): array
    {
        return [
            'title' => self::CATEGORY_UPDATED_TEXT,
            'type'  => self::UPDATED_TYPE,
        ];
    }

    public static function categoryDeleted(): array
    {
        return [
            'title' => self::CATEGORY_DELETED_TEXT,
            'type'  => self::DELETED_TYPE,
        ];
    }

    //product

    public static function productCreated(): array
    {
        return [
            'title' => self::PRODUCT_CREATED_TEXT,
            'type'  => self::CREATED_TYPE,
        ];
    }

    public static function productUpdated(): array
    {
        return [
            'title' => self::PRODUCT_UPDATED_TEXT,
            'type'  => self::UPDATED_TYPE,
        ];
    }

    public static function productDeleted(): array
    {
        return [
            'title' => self::PRODUCT_DELETED_TEXT,
            'type'  => self::DELETED_TYPE,
        ];
    }

    //payment

    public static function paymentCreated(): array
    {
        return [
            'title' => self::PAYMENT_CREATED_TEXT,
            'type'  => self::CREATED_TYPE,
        ];
    }

    public static function paymentUpdated(): array
    {
        return [
            'title' => self::PAYMENT_UPDATED_TEXT,
            'type'  => self::UPDATED_TYPE,
        ];
    }

    public static function paymentDeleted(): array
    {
        return [
            'title' => self::PAYMENT_DELETED_TEXT,
            'type'  => self::DELETED_TYPE,
        ];
    }

    //service

    public static function serviceCreated(): array
    {
        return [
            'title' => self::SERVICE_CREATED_TEXT,
            'type'  => self::CREATED_TYPE,
        ];
    }

    public static function serviceUpdated(): array
    {
        return [
            'title' => self::SERVICE_UPDATED_TEXT,
            'type'  => self::UPDATED_TYPE,
        ];
    }

    public static function serviceDeleted(): array
    {
        return [
            'title' => self::SERVICE_DELETED_TEXT,
            'type'  => self::DELETED_TYPE,
        ];
    }
}
