<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use http\Client;
use Illuminate\Support\Facades\Http;

trait IssueManagerTrait
{
    public function createIssue($data)
    {
        $endpoint = 'rest/servicedeskapi/request';
        $response = $this->client->post($endpoint, [
            'json' => $data,

        ]);

        return json_decode($response->getBody()->getContents());
    }



    public function getIssue(string $issueKey)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function updateIssue(string $issueKey, array $data)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}";
        $response = $this->client->put($endpoint, [
            'json' => $data
        ]);
        return json_decode($response->getBody()->getContents());
    }

    public function deleteIssue(string $issueKey)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}";
        $response = $this->client->delete($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function addComment(string $issueKey, array $data)
    {
//        servicedesk/{$serviceDeskId}
        $endpoint = "rest/servicedeskapi/request/{$issueKey}/comment";
        $response = $this->client->post($endpoint, [
            'json' => $data
        ]);
        return json_decode($response->getBody()->getContents());
    }

    public function addAttachment(string $issueKey, $data)
    {
        $endpoint = "rest/servicedeskapi/request/{$issueKey}/attachment";
        $response = $this->client->post($endpoint, [
            'json' => $data,

        ]);
//        $response = $this->client->post($endpoint, [
//            'multipart' => [
//                [
//                    'name' => 'file',
//                    'contents' => $attachment
//                ]
//            ]
//        ]);
        return json_decode($response->getBody()->getContents());
    }

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
