<?php

namespace TianSchutte\ServiceDeskJira\Traits;

trait TicketManagerTrait
{
    public function getTypes(string $serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getTypeById(string $serviceDeskId, string $requestTypeId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype/{$requestTypeId}";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function createType(string $serviceDeskId, array $data)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype";
        $response = $this->client->post($endpoint, [
            'json' => $data
        ]);
        return json_decode($response->getBody()->getContents());
    }

    public function getFields(string $serviceDeskId, string $requestTypeId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype/{$requestTypeId}/field?expand=serviceDesk&expand=requestType";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getTypeGroup(string $serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype/group";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getTypeFields(string $serviceDeskId, string $requestTypeId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype/{$requestTypeId}/field";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

}
