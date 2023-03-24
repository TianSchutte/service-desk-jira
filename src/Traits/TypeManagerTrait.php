<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use Exception;
use GuzzleHttp\Exception\RequestException;
use TianSchutte\ServiceDeskJira\Exceptions\ServiceDeskException;

trait TypeManagerTrait
{

    /**
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getTypes()
    {
        $endpoint = "{$this->restServiceDeskApiServiceDesk}/{$this->serviceDeskId}/requesttype";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving types.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $requestTypeId
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getTypeById(string $requestTypeId)
    {
        $endpoint = "{$this->restServiceDeskApiServiceDesk}/{$this->serviceDeskId}/requesttype/{$requestTypeId}";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving type by id.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param array $data
     * @return mixed
     * @throws ServiceDeskException
     */
    public function createType(array $data)
    {
        $endpoint = "{$this->restServiceDeskApiServiceDesk}/{$this->serviceDeskId}/requesttype";

        try {
            $response = $this->client->post($endpoint, [
                'json' => $data
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while creating a tickets.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $requestTypeId
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getFields(string $requestTypeId)
    {
        $endpoint = "{$this->restServiceDeskApiServiceDesk}/{$this->serviceDeskId}/requesttype/{$requestTypeId}/field?expand=serviceDesk&expand=requestType";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving fields.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getTypeGroup()
    {
       $endpoint = "{$this->restServiceDeskApiServiceDesk}/{$this->serviceDeskId}/requesttypegroup";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving type groups.');

        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $requestTypeId
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getTypeFields(string $requestTypeId)
    {
        $endpoint = "{$this->restServiceDeskApiServiceDesk}/{$this->serviceDeskId}/requesttype/{$requestTypeId}/field";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving type fields.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }
}
