<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use Exception;
use GuzzleHttp\Exception\RequestException;
use TianSchutte\ServiceDeskJira\Exceptions\ServiceDeskException;

trait UtilityManagerTrait
{

    /**
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getServices()
    {
        $prefix = config('service-desk-jira.api_prefix.rest_service_registry');
        $endpoint = "{$prefix}/service?query=";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving services.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }
}
