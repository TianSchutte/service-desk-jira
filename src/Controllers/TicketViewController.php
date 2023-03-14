<?php

namespace TianSchutte\ServiceDeskJira\Controllers;

use Illuminate\Http\Request;
use TianSchutte\ServiceDeskJira\Services\JiraServiceDeskService;

class TicketViewController
{
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
    public function showTicketMenu(Request $request)
    {
        return view('service-desk-jira::ticket-menu');
    }

    public function index(Request $request)
    {
        $tickets = $this->jiraServiceDeskService->getUserTickets('tian@giantprocurement.guru');

        return view('service-desk-jira::ticket-view-index',[
            'tickets' => $tickets
        ]);
    }

    public function show($id)
    {
        $issue = $this->jiraServiceDeskService->getIssue($id);

        return view('service-desk-jira::ticket-view-show',[
            'issue' => $issue,
        ]);
    }

    public function storeComment(Request $request)
    {
        $issueKey = $request->input('issue_key');
        $commentBody = $request->input('comment_body');

        $data = [
            'body' => $commentBody,
            'public' => true,
            //                'raiseOnBehalfOf' => 'rickusvega@gmail.com' TODO somehow get from GLE/GSC side, also need to have some sort of email validation
        ];

        $this->jiraServiceDeskService->addComment($issueKey, $data);

        return view('service-desk-jira::ticket-menu');
    }
}
