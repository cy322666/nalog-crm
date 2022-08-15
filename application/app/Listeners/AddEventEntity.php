<?php

namespace App\Listeners;

use App\Events\Shop\EntityEvent;
use App\Facades\EventLogger;
use App\Models\Shop\Shop;
use App\Services\Event\EventDto;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class AddEventEntity implements ShouldQueue
{
    /**
     * Добавляет инфу о событии сущности в выбранный storage
     *
     * @param EntityEvent $event
     * @return void
     */
    public function handle(EntityEvent $event)
    {
        EventLogger::set(new EventDto(
            $event->entity::TYPE,
            $event->entity->id,
            $event->info['title'],
            $event->entity->account->id ?? Shop::query()->first()->id,
            $event->info['type'],
            $event->author->name,
            $event->entity->name ?? $event->entity->title,
        ));
    }
}
