<?php

namespace TianSchutte\ServiceDeskJira\Traits;

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
        $endpoint = 'rest/servicedeskapi/info';

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving info.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getServiceDesks()
    {
        $endpoint = 'rest/servicedeskapi/servicedesk';

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving service desks.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @param $serviceDeskId
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getServiceDeskById($serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving service desk by id.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @param $serviceDeskId
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getQueues($serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/queue";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving queues.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @param $serviceDeskId
     * @param $queueId
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getIssuesInQueue($serviceDeskId, $queueId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/queue/{$queueId}/issue";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving issues in queue.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }
}
