<?php

namespace App\Services\Event;

class EventDto
{
    /**
     * @param int $modelTypeId id типа класса сущности
     * @param int $modelId id модели изменения
     * @param string $title название события
     * @param int $shopId id аккаунта
     * @param int $typeId id типа события
     * @param string $authorName автор изменнеия
     */
    public function __construct(
        public int $modelTypeId,
        public int $modelId,
        public string $title,
        public int $shopId,
        public int $typeId,
        public string $authorName
    ) {}
}
