<?php

namespace TianSchutte\ServiceDeskJira\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use TianSchutte\ServiceDeskJira\Exceptions\ServiceDeskException;
use TianSchutte\ServiceDeskJira\Services\ServiceDeskService;

class TicketFormController
{
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

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index()
    {
        try {
            $typeGroups = $this->jiraServiceDeskService->getTypeGroup()->values;
        } catch (ServiceDeskException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return view('service-desk-jira::ticket-form-index', [
            'typeGroups' => $typeGroups
        ]);
    }

    /**
     * @param $groupId
     * @return Application|Factory|View|RedirectResponse
     */
    public function group($groupId)
    {
        try {
            $requestTypes = $this->jiraServiceDeskService->getTypes()->values;
        } catch (ServiceDeskException $e) {
            return back()->with('error', $e->getMessage())->withInput();
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
            $fieldValues = $this->jiraServiceDeskService->getServiceAndUserFields($fields);
            $typeValues = $this->jiraServiceDeskService->getTypeById($id);
        } catch (ServiceDeskException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return view('service-desk-jira::ticket-form-show', [
            'fields' => $fields,
            'requestType' => $typeValues,
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

        $validatedData = $request->validate([
            'summary' => 'required',
            'description' => 'required'
        ]);

        try {
            $issueRequest = $this->jiraServiceDeskService->createIssue([
                'requestFieldValues' => $fieldValues,
                'serviceDeskId' => $this->project_id,
                'requestTypeId' => $requestTypeId,
                'raiseOnBehalfOf' => Auth::user()->email
            ]);
        } catch (ServiceDeskException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        $attachedFiles = $this->jiraServiceDeskService->AttachFiles($request, $issueRequest);
//dd($attachedFiles);
        try {
            $this->assignAssignee($issueRequest->issueKey);
        }catch (ServiceDeskException $e) {
            //quietly fail
        }

        return view('service-desk-jira::ticket-form-store', [
            'requestTypeId' => $requestTypeId,
            'attachedFiles' => $attachedFiles,
            'issueRequest' => $issueRequest,
        ]);
    }

    /**
     * @param $issueKey
     * @return void
     * @throws ServiceDeskException
     */
    private function assignAssignee($issueKey)
    {
        $customerTickets = $this->jiraServiceDeskService->getCustomerByEmail(
            config('service-desk-jira.default_assignee')
        );

        $assignee = $this->jiraServiceDeskService->addAssignee($issueKey, [
            'accountId' => $customerTickets[0]->accountId,
        ]);
    }
}
