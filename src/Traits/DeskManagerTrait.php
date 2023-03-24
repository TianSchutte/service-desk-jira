<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use Exception;
use GuzzleHttp\Exception\RequestException;
use TianSchutte\ServiceDeskJira\Exceptions\ServiceDeskException;

trait DeskManagerTrait
{

    /**
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getInfo()
    {
        $endpoint = "{$this->restServiceDeskApi}/info";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving info.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getServiceDesks()
    {
        $endpoint = "{$this->restServiceDeskApiServiceDesk}";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving service desks.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getServiceDesk()
    {
        $endpoint = "{$this->restServiceDeskApiServiceDesk}/{$this->serviceDeskId}";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving service desk by id.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getQueues()
    {
        $endpoint = "{$this->restServiceDeskApiServiceDesk}/{$this->serviceDeskId}/queue";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving queues.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @param $queueId
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getIssuesInQueue($queueId)
    {
        $endpoint = "{$this->restServiceDeskApiServiceDesk}/{$this->serviceDeskId}/queue/{$queueId}/issue";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving issues in queue.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }
}
