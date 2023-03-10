<?php

namespace TianSchutte\ServiceDeskJira\Traits;

use Exception;

trait DeskManagerTrait
{
    public function getInfo()
    {
        $endpoint = 'rest/servicedeskapi/info';
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getServiceDesks()
    {
        $endpoint = 'rest/servicedeskapi/servicedesk';
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getServiceDeskById($serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getQueues($serviceDeskId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/queue";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getIssuesInQueue($serviceDeskId, $queueId)
    {
        $endpoint = "rest/servicedeskapi/servicedesk/{$serviceDeskId}/queue/{$queueId}/issue";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getServices()
    {
        $endpoint = 'rest/service-registry-api/service?query=';
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getUsers(){
        //https://giantprocurement.atlassian.net/rest/servicedesk/1/customer/portal/6/user-search?fieldConfigId=&fieldName=reporter&query=
        $endpoint = "rest/servicedesk/1/customer/portal/{$this->project_id}/user-search?fieldConfigId=&fieldName=reporter&query=";
        $response = $this->client->get($endpoint);
        return json_decode($response->getBody()->getContents());
    }

    public function getCustomFieldData($customFieldId)
    {

        $jql = "'My Custom Field' = {$customFieldId}";

// Construct the Jira Service Management REST API endpoint URL
        $url = "/rest/servicedeskapi/request?jql=" . urlencode($jql);

        // Fetch the field configuration for the custom field
            $response = $this->client->get($url);
        $fieldConfig = json_decode($response->getBody()->getContents(), true);
        $fieldSchema = $fieldConfig['schema'];

// Check if the field schema is a single-select or multi-select list
        if ($fieldSchema['type'] === 'array') {
            $fieldValues = $fieldSchema['items'];
        } else {
            $fieldValues = $fieldSchema['system'];
        }

// Fetch the relevant issue data using the field ID and value
        $issueDataUrl = '/rest/api/2/search?jql=cf[' . $customFieldId . ']=' . $fieldValues;
        $response = $this->client->get($issueDataUrl);
        $issueData = json_decode($response->getBody(), true);

// Print the issue data
        print_r($issueData);

        return json_decode($response->getBody()->getContents());

    }

}
