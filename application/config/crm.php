<?php

use App\Services\Event\EventStorage\EloquentStorage;

return [
    'url_support' => 'https://t.me/integrator',

    'event_storage' => EloquentStorage::class,

    'storage_disk' => 'public',
];
