<?php

namespace App\Services\Event;

class EventDto
{
    public function __construct(
        public int $modelTypeId,    //id типа класса сущности
        public int $modelId,        //id модели изменения
        public string $title,       //название события
        public int $shopId,         //id аккаунта
        public int $typeId,         //id типа события
        public string $authorName   //автор изменнеия
    ) {}
}
