<?php

namespace App\Services\Event\EventStorage;

use App\Services\Event\EventDto;

interface EventStorageInterface
{
    public function set(EventDto $event);

    public function get($params, $terms);
}
