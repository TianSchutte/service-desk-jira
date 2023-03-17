<?php

namespace TianSchutte\ServiceDeskJira\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use TianSchutte\ServiceDeskJira\Exceptions\ServiceDeskException;
use TianSchutte\ServiceDeskJira\Services\ServiceDeskService;

class TicketViewController
{
    private $project_id;

    /**
     * @var ServiceDeskService
     */
    private $jiraServiceDeskService;

    public function __construct(ServiceDeskService $jiraServiceDeskService)
    {
        $this->project_id = config('service-desk-jira.project_id');
        $this->jiraServiceDeskService = $jiraServiceDeskService;
    }

    public function showTicketMenu()
    {
        //check if customer is added to service desk and add if not
        return view('service-desk-jira::ticket-menu');
    }

    public function index()
    {
        try {
//            TODO query actual email
            $tickets = $this->jiraServiceDeskService->getCustomerTickets('tian@giantprocurement.guru')->issues;
        } catch (ServiceDeskException $e) {
            return redirect()->route('tickets.menu')->with('error', $e->getMessage());
        }

        return view('service-desk-jira::ticket-view-index', [
            'tickets' => $tickets
        ]);
    }

    public function show($id)
    {
        $requestTicketId = $id;

        try {
            $issue = $this->jiraServiceDeskService->getIssue($requestTicketId);
            $comments = $this->jiraServiceDeskService->getComments($requestTicketId)->values;
        } catch (ServiceDeskException $e) {
            return redirect()->route('tickets.view.index')->with('error', $e->getMessage());
        }

        return view('service-desk-jira::ticket-view-show', [
            'issue' => $issue,
            'comments' => $comments
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeComment(Request $request)
    {
        $issueKey = $request->input('issue_key');
        $commentBody = $request->input('comment_body');

        $data = [
            'body' => $commentBody,
            'public' => true,
            //                'raiseOnBehalfOf' => 'rickusvega@gmail.com' TODO somehow get from GLE/GSC side, also need to have some sort of email validation
        ];
        try {
            $this->jiraServiceDeskService->addComment($issueKey, $data);
        } catch (ServiceDeskException $e) {
            return redirect()->route('tickets.view.index')->with('error', $e->getMessage());
        }
        return redirect()->route('tickets.menu')->with('success', 'Comment has been added!');
    }
}
