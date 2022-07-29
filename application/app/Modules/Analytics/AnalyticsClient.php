<?php

namespace App\Modules\Analytics;

use DateTimeInterface;
//use Google_Service_Analytics;
//use Google_Service_Analytics_GaData;
use Illuminate\Contracts\Cache\Repository;

class AnalyticsClient
{
    protected int $cacheLifeTimeInMinutes = 0;

    public function __construct(
        protected $service,
        protected Repository $cache,
    ) {
        //
    }

    public function setCacheLifeTimeInMinutes(int $cacheLifeTimeInMinutes): self
    {
        $this->cacheLifeTimeInMinutes = $cacheLifeTimeInMinutes * 60;

        return $this;
    }

    /**
     * Query the Google Analytics Service with given parameters.
     *
     * @param string $viewId
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     * @param string $metrics
     * @param array $others
     */
    public function performQuery(
        string $viewId,
        DateTimeInterface $startDate,
        DateTimeInterface $endDate,
        string $metrics,
        array $others = [])
    {
        return $this->cache->remember('redis', $this->cacheLifeTimeInMinutes, function () use ($viewId, $startDate, $endDate, $metrics, $others) {
            $result = $this->service->data_ga->get(
                "ga:{$viewId}",
                $startDate->format('Y-m-d'),
                $endDate->format('Y-m-d'),
                $metrics,
                $others,
            );

            while ($nextLink = $result->getNextLink()) {
                if (isset($others['max-results']) && count($result->rows) >= $others['max-results']) {
                    break;
                }

                $options = [];

                parse_str(substr($nextLink, strpos($nextLink, '?') + 1), $options);

                $response = $this->service->data_ga->call('get', [$options], 'Google_Service_Analytics_GaData');

                if ($response->rows) {
                    $result->rows = array_merge($result->rows, $response->rows);
                }

                $result->nextLink = $response->nextLink;
            }

            return $result;
        });
    }

    public function getAnalyticsService()
    {
        return $this->service;
    }

    /**
     * Determine the cache name for the set of query properties given.
     */
    protected function determineCacheName(array $properties): string
    {
        return 'spatie.laravel-analytics.'.md5(serialize($properties));
    }
}
