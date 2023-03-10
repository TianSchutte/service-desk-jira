<?php

namespace TianSchutte\ServiceDeskJira\Controllers;

use Illuminate\Http\Request;
use TianSchutte\ServiceDeskJira\Facades\JiraServiceDeskFacade;

class RequestFormController
{
    private $project_id;

    public function __construct()
    {
        $this->project_id = config('service-desk-jira.project_id');
    }

    public function showIssueTypes(Request $request)//step 1
    {
        $requestTypes = JiraServiceDeskFacade::getTypes($this->project_id)->values;

        return view('service-desk-jira::ticket-form-step-1', [
            'requestTypes' => $requestTypes,
        ]);
    }

    public function showIssueForm(Request $request)//step 2
    {
        $requestTypeId = $request->input('request_type_id');
        $fields = JiraServiceDeskFacade::getFields($this->project_id, $requestTypeId)->requestTypeFields;
        $services = JiraServiceDeskFacade::getServices();
        $users = JiraServiceDeskFacade::getUsers();

//        dd(json_encode($fields));
        return view('service-desk-jira::ticket-form-step-2', [
            'fields' => $fields,
            'requestTypeId' => $requestTypeId,
            'services' => $services,
            'users' => $users,
        ]);
    }

    public function submitIssueForm(Request $request)
    {
        $requestTypeId = $request->input('request_type_id');
        $fieldValues = $request->except('_token', 'request_type_id', 'attachment');

        try {
            $issueRequest = JiraServiceDeskFacade::createIssue([
                'requestFieldValues' => $fieldValues,
                'serviceDeskId' => $this->project_id,
                'requestTypeId' => ($requestTypeId),
//                'raiseOnBehalfOf' => 'rickusvega@gmail.com' TODO somehow get from GLE/GSC side, also need to have some sort of email validation
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
//        dd(json_encode($fields));

        $attachedFiles = $this->AttachFiles($request, $issueRequest);

//        TODO: add some sort of notification/view to show user that the ticket has been submitted
        return json_encode($attachedFiles);
    }

    private function AttachFiles($request, $issueRequest)
    {
        if (!$request->hasFile('attachment')) {
            return 'No Files Attached';
        }

        $temporaryAttachmentIds = array();

        foreach ($request->file('attachment') as $file) {
            $response = JiraServiceDeskFacade::attachTemporaryFile($this->project_id, $file);
            $temporaryAttachmentIds[] = $response->temporaryAttachments[0]->temporaryAttachmentId;
        }

        $data = [
            'temporaryAttachmentIds' => $temporaryAttachmentIds,
            'public' => true,
            "additionalComment" => [
                "body" => "System Attached File."
            ]
        ];

        return JiraServiceDeskFacade::addAttachment($issueRequest->issueId, $data);
    }
}
