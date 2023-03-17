<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use GuzzleHttp\Exception\RequestException;
use TianSchutte\ServiceDeskJira\Exceptions\ServiceDeskException;

trait CustomerManagerTrait
{

    /**
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getCustomers()
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
    public function getCustomerTickets($userEmail)
    {
        if (!$this->getServiceDeskById($this->project_id)) {
            throw new ServiceDeskException('Service desk not found.');
        }

        $projectKey = $this->getServiceDeskById($this->project_id)->projectKey;

        $endpoint = "/rest/api/2/search?jql=project = $projectKey AND (reporter = '$userEmail')&fields=summary";

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
     * @param $userEmail
     * @param $fullName
     * @return mixed
     * @throws ServiceDeskException
     */
    public function createCustomer($userEmail, $fullName)
    {
        //Not Used.
        //JIRA administrator global permission is required to create a customer.
        $endpoint = "/rest/servicedeskapi/customer/";

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
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $userEmail
     * @param $serviceDeskId
     * @return mixed
     * @throws ServiceDeskException
     */
    public function addCustomerToServiceDesk($userEmail)
    {
        //requires add customer to function afaik
        $endpoint = "/rest/servicedeskapi/servicedesk/{$this->project_id}/customer";

        $data = [
            'usernames' => [$userEmail],
        ];

        try {
            $response = $this->client->post($endpoint, [
                'json' => $data,
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while adding user to service desk.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }
}