<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;

trait DeskManagerTrait
{
    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function getInfo()
    {
        $endpoint = 'rest/servicedeskapi/info';
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function getServiceDesks()
    {
        $endpoint = 'rest/servicedeskapi/servicedesk';
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $serviceDeskId
     * @return mixed
     * @throws GuzzleException
     */
    public function getServiceDeskById($serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}";
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $serviceDeskId
     * @return mixed
     * @throws GuzzleException
     */
    public function getQueues($serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/queue";
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $serviceDeskId
     * @param $queueId
     * @return mixed
     * @throws GuzzleException
     */
    public function getIssuesInQueue($serviceDeskId, $queueId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/queue/{$queueId}/issue";
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }
}
