<?php

namespace TianSchutte\ServiceDeskJira\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use TianSchutte\ServiceDeskJira\Exceptions\ServiceDeskException;
use TianSchutte\ServiceDeskJira\Services\ServiceDeskService;

class TicketFormController
{
    const SERVICES_FIELD_ID = 'customfield_10051';
    const USERS_FIELD_ID = 'customfield_10003';

    /**
     * @var mixed
     */
    private $project_id;

    /**
     * @var Application|mixed
     */
    private $jiraServiceDeskService;

    /**
     * TicketFormController constructor.
     * @param ServiceDeskService $jiraServiceDeskService
     */
    public function __construct(ServiceDeskService $jiraServiceDeskService)
    {
        $this->project_id = config('service-desk-jira.project_id');
        $this->jiraServiceDeskService = $jiraServiceDeskService;
    }

    public function index()
    {
        try {
            $typeGroups = $this->jiraServiceDeskService->getTypeGroup()->values;
        } catch (ServiceDeskException $e) {
            return redirect()->route('tickets.menu')->with('error', $e->getMessage());
        }
        return view('service-desk-jira::ticket-form-index', [
            'typeGroups' => $typeGroups
        ]);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function group($groupId)
    {
        try {
            $requestTypes = $this->jiraServiceDeskService->getTypes()->values;
        } catch (ServiceDeskException $e) {
            return redirect()->route('tickets.menu')->with('error', $e->getMessage());
        }

        $validRequestTypes = [];
        foreach ($requestTypes as $requestType) {
            if (in_array($groupId, $requestType->groupIds)) {
                $validRequestTypes[] = $requestType;
            }
        }

        return view('service-desk-jira::ticket-form-group', [
            'requestTypes' => $validRequestTypes
        ]);
    }

    /**
     * @param $id //requestTypeId
     * @return Application|Factory|View|RedirectResponse
     */
    public function show($id)
    {
        try {
            $fields = $this->jiraServiceDeskService->getFields($id)->requestTypeFields;
            $fieldValues = $this->getServiceAndUserFields($fields);
        } catch (ServiceDeskException $e) {
            return redirect()->route('tickets.form.index')->with('error', $e->getMessage());
        }

        return view('service-desk-jira::ticket-form-show', [
            'fields' => $fields,
            'requestTypeId' => $id,
            'services' => $fieldValues['services'],
            'users' => $fieldValues['users'],
        ]);
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function store(Request $request)
    {
        $requestTypeId = $request->input('request_type_id');
        $fieldValues = $request->except('_token', 'request_type_id', 'attachment');

        foreach ($fieldValues as $key => $value) {
            if ($value === null) {
                $fieldValues[$key] = '';
            }
        }

        try {
            $issueRequest = $this->jiraServiceDeskService->createIssue([
                'requestFieldValues' => $fieldValues,
                'serviceDeskId' => $this->project_id,
                'requestTypeId' => $requestTypeId,
//                'raiseOnBehalfOf' => 'rickusvega@gmail.com'// TODO somehow get from GLE/GSC side, also need to have some sort of email validation/
            ]);
        } catch (ServiceDeskException $e) {
            return redirect()->route('tickets.form.index')->with('error', $e->getMessage());
        }

        $attachedFiles = $this->AttachFiles($request, $issueRequest);

        return view('service-desk-jira::ticket-form-store', [
            'requestTypeId' => $requestTypeId,
            'attachedFiles' => $attachedFiles,
            'issueRequest' => $issueRequest,
        ]);
    }

    /**
     * @param $fields
     * @return array
     * @throws ServiceDeskException
     */
    private function getServiceAndUserFields($fields): array
    {
        $services = [];
        $users = [];

        foreach ($fields as $field) {
            switch ($field->fieldId) {
                case self::SERVICES_FIELD_ID:
                    $services = $this->jiraServiceDeskService->getServices();
                    break;
                case self::USERS_FIELD_ID:
                    $users = $this->jiraServiceDeskService->getCustomers();
                    break;
            }
        }

        return [
            'services' => $services,
            'users' => $users,
        ];
    }


    /**
     * @param $request
     * @param $issueRequest
     * @return null|mixed
     */
    private function AttachFiles($request, $issueRequest)
    {
        if (!$request->hasFile('attachment')) {
            return null;
        }

        $temporaryAttachmentIds = array();

        foreach ($request->file('attachment') as $file) {
            try {
                $response = $this->jiraServiceDeskService->attachTemporaryFile($file);
                $temporaryAttachmentIds[] = $response->temporaryAttachments[0]->temporaryAttachmentId;
            } catch (ServiceDeskException $e) {
                return redirect()->route('tickets.form.index')->with('error', $e->getMessage());
            }
        }

        $data = [
            'temporaryAttachmentIds' => $temporaryAttachmentIds,
            'public' => true,
            "additionalComment" => [
                "body" => "System Attached File."
            ]
        ];

        try {
            $addAttachmentResponse = $this->jiraServiceDeskService->addAttachment($issueRequest->issueId, $data);
        } catch (ServiceDeskException $e) {
            return redirect()->route('tickets.form.index')->with('error', $e->getMessage());
        }

        return $addAttachmentResponse;
    }
}
