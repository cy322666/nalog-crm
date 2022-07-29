<?php

namespace App\Services\Event;

use App\Services\Event\EventStorage\EventStorageInterface;
use Illuminate\Support\Facades\Config;

class EventService
{
    public const CREATED_TYPE = 1;
    public const UPDATED_TYPE = 2;
    public const DELETED_TYPE = 3;

    public const CUSTOMER_UPDATED_TEXT = 'Клиент обновлен';
    public const CUSTOMER_CREATED_TEXT = 'Клиент создан';
    public const CUSTOMER_DELETED_TEXT = 'Клиент удален';

    private EventStorageInterface $storage;

    public function __construct()
    {
        $this->storage = new (Config::get('crm.events'));
    }

    public function set(EventDto $event)
    {
        $this->storage->set($event);
    }

    public function get(array $key)
    {
        return $this->storage->get($key);
    }
}
