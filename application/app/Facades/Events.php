<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Events extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'events';
    }
}
