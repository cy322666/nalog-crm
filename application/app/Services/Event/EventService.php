<?php

namespace App\Services\Event;

use Illuminate\Support\Facades\Config;

class EventService
{
    private EventStrategyInterface $strategy;

    public function __construct()
    {
        $this->strategy = new (Config::get('crm.events'));
    }

    public function set(EventDto $event)
    {
        $this->strategy->set($event);
    }

    public function get(array $key)
    {
        return $this->strategy->get($key);
    }
}
