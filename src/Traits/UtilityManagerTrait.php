<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use GuzzleHttp\Exception\RequestException;
use TianSchutte\ServiceDeskJira\Exceptions\ServiceDeskException;

trait UtilityManagerTrait
{

    /**
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getServices()
    {
        $endpoint = 'rest/service-registry-api/service?query=';

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving services.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getUsers()
    {
        $endpoint = "rest/servicedesk/1/customer/portal/{$this->project_id}/user-search?fieldConfigId=&fieldName=reporter&query=";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving users.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @param $userEmail
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getUserTickets($userEmail)
    {
        if (!$this->getServiceDeskById($this->project_id)) {
            throw new ServiceDeskException('Service desk not found.');
        }

        $projectKey = $this->getServiceDeskById($this->project_id)->projectKey;

        $endpoint = "/rest/api/2/search?jql=project = $projectKey AND (reporter = '$userEmail')";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving user tickets.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @throws ServiceDeskException
     */
    public function handleGuzzleErrorResponse($response, $failedMessage = 'Unknown error occurred.')
    {
        $responseBody = json_decode($response->getBody()->getContents(), true);
        $failedMessage = $responseBody['errorMessage'] ?? $failedMessage;

        throw new ServiceDeskException($failedMessage);
    }
}
