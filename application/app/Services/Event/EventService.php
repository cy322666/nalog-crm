<?php

namespace App\Services\Event;

use App\Services\Event\EventStorage\EventStorageInterface;
use Illuminate\Support\Facades\Config;

class EventService
{
    private EventStorageInterface $storage;

    public function __construct()
    {
        $this->storage = new (Config::get('crm.event_storage'));
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
