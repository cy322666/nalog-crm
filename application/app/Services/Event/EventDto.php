<?php

namespace App\Services\Event;

class EventDto
{
    public function __construct(
        public string $model,
        public int $modelId,
        public string $text,
        public int $shopId,
        public string $type,
        public string $authorName,
    ) {}
}
