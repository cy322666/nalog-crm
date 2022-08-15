<?php

namespace App\Services\Event;

class EventDto
{
    /**
     * @param int $modelTypeId Id типа класса сущности
     * @param int $modelId Id модели изменения
     * @param string $title Название события
     * @param int $shopId id аккаунта
     * @param int $typeId Id типа события
     * @param string $authorName Автор изменения
     * @param string $modelName Название сущности
     */
    public function __construct(
        public int $modelTypeId,
        public int $modelId,
        public string $title,
        public int $shopId,
        public int $typeId,
        public string $authorName,
        public string $modelName,
    ) {}
}
