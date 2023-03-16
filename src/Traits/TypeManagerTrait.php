<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use GuzzleHttp\Exception\RequestException;
use TianSchutte\ServiceDeskJira\Exceptions\ServiceDeskException;

trait TypeManagerTrait
{

    /**
     * @param string $serviceDeskId
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getTypes(string $serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving types.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $serviceDeskId
     * @param string $requestTypeId
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getTypeById(string $serviceDeskId, string $requestTypeId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype/{$requestTypeId}";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving type by id.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $serviceDeskId
     * @param array $data
     * @return mixed
     * @throws ServiceDeskException
     */
    public function createType(string $serviceDeskId, array $data)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype";

        try {
            $response = $this->client->post($endpoint, [
                'json' => $data
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while creating a tickets.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $serviceDeskId
     * @param string $requestTypeId
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getFields(string $serviceDeskId, string $requestTypeId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype/{$requestTypeId}/field?expand=serviceDesk&expand=requestType";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving fields.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $serviceDeskId
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getTypeGroup(string $serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype/group";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving type groups.');

        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $serviceDeskId
     * @param string $requestTypeId
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getTypeFields(string $serviceDeskId, string $requestTypeId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/requesttype/{$requestTypeId}/field";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving type fields.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }
}
