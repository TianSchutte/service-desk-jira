<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use Exception;
use GuzzleHttp\Exception\RequestException;
use TianSchutte\ServiceDeskJira\Exceptions\ServiceDeskException;

trait IssueManagerTrait
{

    /**
     * @param $data
     * @return mixed
     * @throws ServiceDeskException
     */
    public function createIssue(array $data)
    {
        $endpoint = "{$this->restServiceDeskApi}/request";

        try {
            $response = $this->client->post($endpoint, [
                'json' => $data,
            ]);

        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while creating issue. Please make sure all fields are filled');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
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
        $endpoint = "{$this->restServiceDeskApi}/request/{$issueKey}";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while retrieving issue.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
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
        $endpoint = "{$this->restServiceDeskApi}/request/{$issueKey}";

        try {
            $response = $this->client->put($endpoint, [
                'json' => $data
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while updating issue.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
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
        $endpoint = "{$this->restServiceDeskApi}/request/{$issueKey}/comment";

        try {
            $response = $this->client->post($endpoint, [
                'json' => $data
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while adding comment.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
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
       $endpoint = "{$this->restServiceDeskApi}/request/{$issueKey}/comment";

        try {
            $response = $this->client->get($endpoint);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while getting comments.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
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
        $endpoint = "{$this->restServiceDeskApi}/request/{$issueKey}/attachment";

        try {
            $response = $this->client->post($endpoint, [
                'json' => $data,
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while adding Attachment.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $file
     * @return mixed
     * @throws ServiceDeskException
     */
    public function attachTemporaryFile($file)
    {
        $endpoint = "{$this->restServiceDeskApiServiceDesk}/{$this->serviceDeskId}/attachTemporaryFile";

        try {
            $response = $this->client->post($endpoint, [
                'headers' => [
                    'X-Atlassian-Token' => 'no-check'
                ],
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => file_get_contents($file->getPathname()),
                        'filename' => $file->getClientOriginalName()
                    ]
                ]
            ]);

        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while attaching temporary file.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $issueKey
     * @param array $data
     * @return mixed
     * @throws ServiceDeskException
     */
    public function addAssignee(string $issueKey, array $data)
    {
        $endpoint = "{$this->restApi}/2/issue/{$issueKey}/assignee";

        try {
            $response = $this->client->put($endpoint, [
                'json' => $data
            ]);
        } catch (RequestException $e) {
            $this->handleGuzzleErrorResponse($e->getResponse(), 'Unknown error occurred while adding assignee.');
        } catch (Exception $e) {
            throw new ServiceDeskException($e->getMessage(), $e->getCode(), $e);
        }

        return json_decode($response->getBody()->getContents());
    }
}
