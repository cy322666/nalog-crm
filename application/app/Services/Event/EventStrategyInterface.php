<?php

namespace App\Services\Event;

interface EventStrategyInterface
{
    public function set(EventDto $event);

    public function get($params, $terms);
}
