<?php

namespace  App\Modules\Notification\Actions\Concerns;


use App\Modules\Notification\NotificationFeed;

trait BelongsToLivewire
{
    protected NotificationFeed $livewire;

    public function livewire(NotificationFeed $livewire): static
    {
        $this->livewire = $livewire;

        return $this;
    }

    public function getLivewire(): NotificationFeed
    {
        return $this->livewire;
    }
}
