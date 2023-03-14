<?php

namespace TianSchutte\ServiceDeskJira\Controllers;

use Illuminate\Http\Request;
use TianSchutte\ServiceDeskJira\Services\JiraServiceDeskService;

class TicketFormController
{
    const SERVICES_FIELD_ID = 'customfield_10051';
    const USERS_FIELD_ID = 'customfield_10003';

    private $project_id;
    /**
     * @var JiraServiceDeskService
     */
    private $jiraServiceDeskService;

    public function __construct()
    {
        $this->project_id = config('service-desk-jira.project_id');
        $this->jiraServiceDeskService = app('service-desk-jira');
    }

    public function index(Request $request)//step 1
    {
        $requestTypes = $this->jiraServiceDeskService->getTypes($this->project_id)->values;

        return view('service-desk-jira::ticket-form-step-1', [
            'requestTypes' => $requestTypes,
        ]);
    }

    public function show(Request $request)//step 2
    {
        $requestTypeId = $request->input('request_type_id');
        $fields = $this->jiraServiceDeskService->getFields($this->project_id, $requestTypeId)->requestTypeFields;
        $services = [];
        $users = [];

        //todo: maybe seperate this?
        foreach ($fields as $field) {
            switch ($field->fieldId) {
                case self::SERVICES_FIELD_ID:
                    $services = $this->jiraServiceDeskService->getServices();
                    break;
                case self::USERS_FIELD_ID:
                    $users = $this->jiraServiceDeskService->getUsers();
                    break;
            }
        }

//        dd($fields);
        return view('service-desk-jira::ticket-form-step-2', [
            'fields' => $fields,
            'requestTypeId' => $requestTypeId,
            'services' => $services,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $requestTypeId = $request->input('request_type_id');
        $fieldValues = $request->except('_token', 'request_type_id', 'attachment');

        try {
            $issueRequest = $this->jiraServiceDeskService->createIssue([
                'requestFieldValues' => $fieldValues,
                'serviceDeskId' => $this->project_id,
                'requestTypeId' => $requestTypeId,
//                'raiseOnBehalfOf' => 'rickusvega@gmail.com' TODO somehow get from GLE/GSC side, also need to have some sort of email validation
            ]);
        } catch (\Exception $e) {
            dd($e);
        }

        $attachedFiles = $this->AttachFiles($request, $issueRequest);

        return view('service-desk-jira::ticket-form-step-3', [
            'requestTypeId' => $requestTypeId,
            'attachedFiles' => $attachedFiles,
            'issueRequest' => $issueRequest,
        ]);
    }


    private function AttachFiles($request, $issueRequest)
    {
        if (!$request->hasFile('attachment')) {
            return null;
        }

        $temporaryAttachmentIds = array();

        foreach ($request->file('attachment') as $file) {
            $response = $this->jiraServiceDeskService->attachTemporaryFile($this->project_id, $file);
            $temporaryAttachmentIds[] = $response->temporaryAttachments[0]->temporaryAttachmentId;
        }

        $data = [
            'temporaryAttachmentIds' => $temporaryAttachmentIds,
            'public' => true,
            "additionalComment" => [
                "body" => "System Attached File."
            ]
        ];

        return $this->jiraServiceDeskService->addAttachment($issueRequest->issueId, $data);
    }
}
