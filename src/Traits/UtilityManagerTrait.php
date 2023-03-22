<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use Exception;
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
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @throws ServiceDeskException
     */
    public function handleGuzzleErrorResponse($response, $failedMessage = 'Unknown error occurred.')
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 400 && $statusCode < 500) {
            $responseBody = json_decode($response->getBody()->getContents(), true);
//            $failedMessage = $responseBody['errorMessages'][0] ?? $failedMessage; //Invalid request payload. Refer to the REST API documentation and try again.
            $failedMessage = "Invalid request. Please make sure all fields are filled.";
        } elseif ($statusCode >= 500 && $statusCode < 600) {
            $failedMessage = 'A server error occurred. Please try again later.';
        } else {
            $responseBody = json_decode($response->getBody()->getContents(), true);
            $failedMessage = $responseBody['errorMessages'][0] ?? $failedMessage;
        }

        throw new ServiceDeskException($failedMessage);
    }
}
