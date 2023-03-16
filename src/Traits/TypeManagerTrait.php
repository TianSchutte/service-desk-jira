<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use GuzzleHttp\Exception\GuzzleException;

trait TypeManagerTrait
{
    /**
     * @param string $serviceDeskId
     * @return mixed
     * @throws GuzzleException
     */
    public function getTypes(string $serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype";

        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $serviceDeskId
     * @param string $requestTypeId
     * @return mixed
     * @throws GuzzleException
     */
    public function getTypeById(string $serviceDeskId, string $requestTypeId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype/{$requestTypeId}";
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $serviceDeskId
     * @param array $data
     * @return mixed
     * @throws GuzzleException
     */
    public function createType(string $serviceDeskId, array $data)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype";
        $response = $this->client->post($endpoint, [
            'json' => $data
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $serviceDeskId
     * @param string $requestTypeId
     * @return mixed
     * @throws GuzzleException
     */
    public function getFields(string $serviceDeskId, string $requestTypeId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype/{$requestTypeId}/field?expand=serviceDesk&expand=requestType";
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $serviceDeskId
     * @return mixed
     * @throws GuzzleException
     */
    public function getTypeGroup(string $serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype/group";
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $serviceDeskId
     * @param string $requestTypeId
     * @return mixed
     * @throws GuzzleException
     */
    public function getTypeFields(string $serviceDeskId, string $requestTypeId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype/{$requestTypeId}/field";
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }
}
