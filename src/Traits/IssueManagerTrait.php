<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use TianSchutte\ServiceDeskJira\Exceptions\ServiceDeskException;

trait IssueManagerTrait
{

    /**
     * @param $data
     * @return mixed
     * @throws ServiceDeskException
     */
    public function createIssue($data)
    {
        $endpoint = 'rest/servicedeskapi/request';

        try {
            $response = $this->client->post($endpoint, [
                'json' => $data,
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while creating issue.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $issueKey
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getIssue(string $issueKey)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving issue.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $issueKey
     * @param array $data
     * @return mixed
     * @throws ServiceDeskException
     */
    public function updateIssue(string $issueKey, array $data)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}";

        try {
            $response = $this->client->put($endpoint, [
                'json' => $data
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while updating issue.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $issueKey
     * @return mixed
     * @throws ServiceDeskException
     */
    public function deleteIssue(string $issueKey)
    {
//      TODO: Remove  DoESNT EXISTS
        $endpoint = "rest/servicedeskapi/request/{$issueKey}";

        try {
            $response = $this->client->delete($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while deleting issue.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $issueKey
     * @param array $data
     * @return mixed
     * @throws ServiceDeskException
     */
    public function addComment(string $issueKey, array $data)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}/comment";

        try {
            $response = $this->client->post($endpoint, [
                'json' => $data
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while adding comment.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $issueKey
     * @return mixed
     * @throws ServiceDeskException
     */
    public function getComments(string $issueKey)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}/comment";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while getting comments.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $issueKey
     * @param $data
     * @return mixed
     * @throws ServiceDeskException
     */
    public function addAttachment(string $issueKey, $data)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}/attachment";

        try {
            $response = $this->client->post($endpoint, [
                'json' => $data,
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while adding Attachment.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $serviceDeskId
     * @param $file
     * @return mixed
     * @throws GuzzleException
     * @throws ServiceDeskException
     */
    public function attachTemporaryFile($serviceDeskId, $file)
    {
        $endpoint = "/rest/servicedeskapi/servicedesk/$serviceDeskId/attachTemporaryFile";

        try {
            $response = $this->client->post($endpoint, [
                'headers' => [
                    'X-Atlassian-Token' => 'no-check'
                ],
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => $file,
                        'filename' => $file->getClientOriginalName()
                    ]
                ]
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while attaching temporary file.');
        } catch (\Exception $e) {
            throw new ServiceDeskException($e->getMessage());
        }

        return json_decode($response->getBody()->getContents());
    }
}
