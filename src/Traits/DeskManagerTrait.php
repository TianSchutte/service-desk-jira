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

    public function getServices()
    {
        $endpoint = 'rest/service-registry-api/service?query=';
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }



    public function getUsers(){
        //https://giantprocurement.atlassian.net/rest/servicedesk/1/customer/portal/6/user-search?fieldConfigId=&fieldName=reporter&query=
        $endpoint = "rest/servicedesk/1/customer/portal/{$this->project_id}/user-search?fieldConfigId=&fieldName=reporter&query=";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getUserTickets($userEmail){
        $endpoint = '/rest/servicedeskapi/request?jql=reporter="' . $userEmail . '"';
//        TODO add service desk project id specification
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

}
