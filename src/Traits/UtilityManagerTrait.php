<?php

namespace TianSchutte\ServiceDeskJira\Traits;

trait UtilityManagerTrait
{
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
//        TODO add service desk project id specification to above query
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }
}
