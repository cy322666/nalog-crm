<?php

namespace App\Events\Shop;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class EntityEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Authenticatable $author,
        public Model $entity,
        public array $info,
    ) {}
}
