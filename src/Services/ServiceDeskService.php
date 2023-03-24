<?php

namespace TianSchutte\ServiceDeskJira\Services;

use GuzzleHttp\Client;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use TianSchutte\ServiceDeskJira\Contracts\CustomerManagerInterface;
use TianSchutte\ServiceDeskJira\Contracts\DeskManagerInterface;
use TianSchutte\ServiceDeskJira\Contracts\IssueManagerInterface;
use TianSchutte\ServiceDeskJira\Contracts\TypeManagerInterface;
use TianSchutte\ServiceDeskJira\Contracts\UtilityManagerInterface;
use TianSchutte\ServiceDeskJira\Exceptions\ServiceDeskException;
use TianSchutte\ServiceDeskJira\Traits\CustomerManagerTrait;
use TianSchutte\ServiceDeskJira\Traits\DeskManagerTrait;
use TianSchutte\ServiceDeskJira\Traits\IssueManagerTrait;
use TianSchutte\ServiceDeskJira\Traits\TypeManagerTrait;
use TianSchutte\ServiceDeskJira\Traits\UtilityManagerTrait;

class ServiceDeskService implements
    IssueManagerInterface,
    DeskManagerInterface,
    TypeManagerInterface,
    CustomerManagerInterface,
    UtilityManagerInterface
{
    use IssueManagerTrait;
    use DeskManagerTrait;
    use TypeManagerTrait;
    use CustomerManagerTrait;
    use UtilityManagerTrait;


    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string|int|mixed
     */
    protected $serviceDeskId;

    protected $restApi;
    protected $restCustomerPortal;
    protected $restServiceDeskApi;
    protected $restServiceDeskApiServiceDesk;

    /**
     * JiraServiceDeskService constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
//            'X-Atlassian-Token'=>'no-check',
//            'X-XSRF-Token'=>'no-check',
            'X-ExperimentalApi' => 'opt-in',
            'base_uri' => config('service-desk-jira.base_url'),
            'auth' =>
                [
                    config('service-desk-jira.email'),
                    config('service-desk-jira.api_key')
                ],
        ]);

        $this->serviceDeskId = config('service-desk-jira.project_id');
        $this->restApi = config('service-desk-jira.api_prefix.rest_api');
        $this->restCustomerPortal = config('service-desk-jira.api_prefix.rest_customer_portal');
        $this->restServiceDeskApi = config('service-desk-jira.api_prefix.rest_service_desk_api');
        $this->restServiceDeskApiServiceDesk = config('service-desk-jira.api_prefix.rest_service_desk_api_service_desk');
    }

    /**
     * @param $request
     * @param $issueRequest
     * @return null|mixed
     */
    public function AttachFiles($request, $issueRequest)
    {
        if (!$request->hasFile('attachment')) {
            return null;
        }

        $temporaryAttachmentIds = array();

        foreach ($request->file('attachment') as $file) {
            try {
                $response = $this->attachTemporaryFile($file);
                $temporaryAttachmentIds[] = $response->temporaryAttachments[0]->temporaryAttachmentId;
            } catch (ServiceDeskException $e) {
                return back()->with('error', $e->getMessage())->withInput();
            }
        }

        $data = [
            'temporaryAttachmentIds' => $temporaryAttachmentIds,
            'public' => true,
            'additionalComment' => [
                'body' => 'System Attached File.'
            ],
        ];

        try {
            $addAttachmentResponse = $this->addAttachment($issueRequest->issueId, $data);
        } catch (ServiceDeskException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return $addAttachmentResponse;
    }

    /**
     * @param $fields
     * @return array
     * @throws ServiceDeskException
     */
    public function getServiceAndUserFields($fields): array
    {
        $SERVICES_FIELD_ID = config('service-desk-jira.field_ids.service_field_id');
        $USER_FIELD_ID = config('service-desk-jira.field_ids.user_field_id');

        $services = [];
        $users = [];

        foreach ($fields as $field) {
            switch ($field->fieldId) {
                case $SERVICES_FIELD_ID:
                    $services = $this->getServices();
                    break;
                case $USER_FIELD_ID:
                    $users = $this->getCustomers();
                    break;
            }
        }

        return [
            'services' => $services,
            'users' => $users,
        ];
    }

    /**
     * @throws ServiceDeskException
     */
    public function handleGuzzleErrorResponse($response, $failedMessage = 'Unknown error occurred.')
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode >= 400 && $statusCode < 500) {
            $failedMessage = 'Invalid request. Please make sure all fields are filled in.';
        } elseif ($statusCode >= 500 && $statusCode < 600) {
            $failedMessage = 'A server error occurred. Please try again later.';
        } else {
            $responseBody = json_decode($response->getBody()->getContents(), true);
            $failedMessage = $responseBody['errorMessages'][0] ?? $failedMessage;
        }

        throw new ServiceDeskException($failedMessage);
    }
}
