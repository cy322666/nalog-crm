<?php

namespace App\Services\Event\EventStorage;

use App\Models\Shop\Event;
use App\Services\Event\EventDto;

class EloquentStorage implements EventStorageInterface
{
    private Event $model;

    public function __construct() {
        $this->model = new Event;
    }

    // see EventDto __construct
    public function set(EventDto $event)
    {
        $this->model
            ->query()
            ->create([
                'model'    => $event->modelTypeId,
                'model_id' => $event->modelId,
                'title'    => $event->title,
                'shop_id'  => $event->shopId,
                'type'     => $event->typeId,
                'author_name' => $event->authorName,
            ]);
    }

    /**
     * @param array $params
     * @example [
     *      ['shop_id', '1'],
     *      ['model', 'Customer'],
     *  ]
     * @param array $terms
     * @example [
     *      [ 'limit' => 10 ]
     * ]
     * @return array events
     */
    public function get($params, $terms = []) : array
    {
        $query = $this->model
            ->query()
            ->where($params);

        $this->applyTerms($query, $terms);

        return $query->get()->toArray();
    }

    private function applyTerms(&$query, array $terms)
    {
        if (count($terms) > 0) {

            foreach ($terms as $key => $term) {

                //TODO add apply terms
            }
        }
    }
}
