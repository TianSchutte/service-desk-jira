<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use GuzzleHttp\Exception\GuzzleException;

trait UtilityManagerTrait
{
    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function getServices()
    {
        $endpoint = 'rest/service-registry-api/service?query=';
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function getUsers()
    {
        $endpoint = "rest/servicedesk/1/customer/portal/{$this->project_id}/user-search?fieldConfigId=&fieldName=reporter&query=";
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $userEmail
     * @return mixed
     * @throws GuzzleException
     */
    public function getUserTickets($userEmail)
    {
        $endpoint = "/rest/servicedeskapi/request?jql=reporter={$userEmail} AND serviceDeskId={$this->project_id}";
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }
}
