<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use Exception;

trait DeskManagerTrait
{
    public function getInfo()
    {
        $endpoint = 'rest/servicedeskapi/info';
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getServiceDesks()
    {
        $endpoint = 'rest/servicedeskapi/servicedesk';
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getServiceDeskById($serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getQueues($serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/queue";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getIssuesInQueue($serviceDeskId, $queueId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/queue/{$queueId}/issue";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }
}
