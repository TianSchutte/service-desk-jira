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
    private $serviceDeskId;

    /**
     * @var Application|mixed
     */
    private $serviceDesk;

    /**
     * TicketFormController constructor.
     * @param ServiceDeskService $serviceDeskService
     */
    public function __construct(ServiceDeskService $serviceDeskService)
    {
        $this->serviceDeskId = config('service-desk-jira.project_id');
        $this->serviceDesk = $serviceDeskService;
    }

    /**
     * @description Shows the groups types to get request types from
     * @return Application|Factory|View|RedirectResponse
     */
    public function index()
    {
        try {
            $typeGroups = $this->serviceDesk->getTypeGroup()->values;
        } catch (ServiceDeskException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return view('service-desk-jira::ticket-form-index', [
            'typeGroups' => $typeGroups
        ]);
    }

    /**
     * @description Shows the request types to generate form from
     * @param $groupId
     * @return Application|Factory|View|RedirectResponse
     */
    public function group($groupId)
    {
        try {
            $requestTypes = $this->serviceDesk->getTypes()->values;
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
     * @description Shows the dynamic form for creating a ticket
     * @param $id //requestTypeId
     * @return Application|Factory|View|RedirectResponse
     */
    public function show($id)
    {
        try {
            $fields = $this->serviceDesk->getFields($id)->requestTypeFields;
            $fieldValues = $this->serviceDesk->getServiceAndUserFields($fields);
            $typeValues = $this->serviceDesk->getTypeById($id);
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
     * @description Creates a ticket
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function store(Request $request)
    {
        $userEmail = optional(Auth::user())->email;

        if (!$userEmail) {
            return redirect()->route('tickets.menu')->with('error', 'You must be logged in to create a ticket.')->withInput();
        }

        $request->validate([
            'summary' => 'required',
            'description' => 'required'
        ]);

        $requestTypeId = $request->input('request_type_id');
        $fieldValues = $request->except('_token', 'request_type_id', 'attachment');

        try {
            $issueRequest = $this->serviceDesk->createIssue([
                'requestFieldValues' => $fieldValues,
                'serviceDeskId' => $this->serviceDeskId,
                'requestTypeId' => $requestTypeId,
                'raiseOnBehalfOf' => $userEmail
            ]);
        } catch (ServiceDeskException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        $attachedFiles = $this->serviceDesk->AttachFiles($request, $issueRequest);

        try {
            $this->assignAssignee($issueRequest->issueKey);
        } catch (ServiceDeskException $e) {
            //quietly fail
        }

        return view('service-desk-jira::ticket-form-store', [
            'attachedFiles' => $attachedFiles,
            'issueRequest' => $issueRequest,
        ]);
    }

    /**
     * @description Assigns the default assignee to the ticket
     * @param $issueKey
     * @return void
     * @throws ServiceDeskException
     */
    private function assignAssignee($issueKey)
    {
        if (config('service-desk-jira.default_assignee') === null) {
            throw new ServiceDeskException('No default assignee set in config file');
        }

        $defaultAssignee = config('service-desk-jira.default_assignee');

        $customers = $this->serviceDesk->getCustomerByEmail($defaultAssignee);

        if (empty($customers)) {
            throw new ServiceDeskException('No customer found with email: ' . $defaultAssignee);
        }

        foreach ($customers as $customer) {
            if ($customer->emailAddress == $defaultAssignee) {
                $this->serviceDesk->addAssignee($issueKey, [
                    'accountId' => $customer->accountId,
                ]);
            }
        }

    }
}
