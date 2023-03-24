<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use Exception;
use GuzzleHttp\Exception\RequestException;
use TianSchutte\ServiceDeskJira\Exceptions\ServiceDeskException;

trait CustomerManagerTrait
{

    /**
     * @param string $customerEmail
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getCustomerByEmail(string $customerEmail)
    {
        $endpoint = "{$this->restCustomerPortal}/{$this->serviceDeskId}/user-search?fieldConfigId=&fieldName=reporter&query=emailAddress='{$customerEmail}'";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving users.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getCustomers()
    {
        $endpoint = "{$this->restCustomerPortal}/{$this->serviceDeskId}/user-search?fieldConfigId=&fieldName=reporter&query=";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving users.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }


    /**
     * @param string $userEmail
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getCustomerTickets(string $userEmail)
    {
        if (!$this->getServiceDesk()) {
            throw new ServiceDeskException('Service desk not found.');
        }

        $projectKey = $this->getServiceDesk()->projectKey;

        $endpoint = "{$this->restApi}/2/search?jql=project = $projectKey AND (reporter = '$userEmail')&fields=summary";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving user tickets.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $userEmail
     * @param string $fullName
     * @return mixed
     * @throws ServiceDeskException
     */
    public function createCustomer(string $userEmail, string $fullName)
    {
        //Not Used.
        //JIRA administrator global permission is required to create a customer.
        $endpoint = "{$this->restServiceDeskApi}/customer/";

        $data = [
            'email' => $userEmail,
            'displayName' => $fullName,
        ];

        try {
            $response = $this->client->post($endpoint, [
                'json' => $data,
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while creating user.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $userEmail
     * @return mixed
     * @throws ServiceDeskException
     */
    public function addCustomerToServiceDesk(string $userEmail)
    {
         //requires add customer to function afaik
        $endpoint = "{$this->restServiceDeskApiServiceDesk}/{$this->serviceDeskId}/customer";

        $data = [
            'usernames' => [$userEmail],
        ];

        try {
            $response = $this->client->post($endpoint, [
                'json' => $data,
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while adding user to service desk.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }
}