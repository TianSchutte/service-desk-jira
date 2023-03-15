<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use GuzzleHttp\Exception\GuzzleException;

trait IssueManagerTrait
{
    /**
     * @param $data
     * @return mixed
     * @throws GuzzleException
     */
    public function createIssue($data)
    {
        $endpoint = 'rest/servicedeskapi/request';
        $response = $this->client->post($endpoint, [
            'json' => $data,
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $issueKey
     * @return mixed
     * @throws GuzzleException
     */
    public function getIssue(string $issueKey)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}";
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $issueKey
     * @param array $data
     * @return mixed
     * @throws GuzzleException
     */
    public function updateIssue(string $issueKey, array $data)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}";
        $response = $this->client->put($endpoint, [
            'json' => $data
        ]);


        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $issueKey
     * @return mixed
     * @throws GuzzleException
     */
    public function deleteIssue(string $issueKey)
    {
//      TODO: Remove  DoESNT EXISTS
        $endpoint = "rest/servicedeskapi/request/{$issueKey}";
        $response = $this->client->delete($endpoint);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $issueKey
     * @param array $data
     * @return mixed
     * @throws GuzzleException
     */
    public function addComment(string $issueKey, array $data)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}/comment";
        $response = $this->client->post($endpoint, [
            'json' => $data
        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $issueKey
     * @return mixed
     * @throws GuzzleException
     */
    public function getComments(string $issueKey)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}/comment";
        $response = $this->client->get($endpoint);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param string $issueKey
     * @param $data
     * @return mixed
     * @throws GuzzleException
     */
    public function addAttachment(string $issueKey, $data)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}/attachment";
        $response = $this->client->post($endpoint, [
            'json' => $data,

        ]);

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $serviceDeskId
     * @param $file
     * @return mixed
     * @throws GuzzleException
     */
    public function attachTemporaryFile($serviceDeskId, $file)
    {
        $endpoint = "/rest/servicedeskapi/servicedesk/$serviceDeskId/attachTemporaryFile";
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

        return json_decode($response->getBody()->getContents());
    }
}
