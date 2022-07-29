<?php

namespace App\Facades;

use App\Services\Event\EventService;
use Illuminate\Support\Facades\Facade;

class EventLogger extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EventService::class;
    }
}
