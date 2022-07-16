<?php

namespace App\Services\Event\EventStrategy;

use App\Models\Shop\Event;
use App\Services\Event\EventDto;
use App\Services\Event\EventStrategyInterface;

class EloquentStrategy implements EventStrategyInterface
{
    public function __construct(private Event $model) {}

    public function set(EventDto $event)
    {
        $this->model
            ->query()->create([
                'model'    => $event->model,
                'model_id' => $event->modelId,
                'text'     => $event->text,
                'shop_id'  => $event->shopId,
                'type'     => $event->type,
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
