<?php

namespace TianSchutte\ServiceDeskJira\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $actions = [];
        $user_email = null;

        if (Auth::user() !== null) {
            $user_email = Auth::user()->email;
            $actions = [
                0 => [
                    'name' => 'Create a Ticket',
                    'url' => route('tickets.form.index')
                ],
                1 => [
                    'name' => 'View a Ticket',
                    'url' => route('tickets.view.index')
                ]
            ];
        }

        return view('service-desk-jira::ticket-menu', [
            'actions' => $actions,
            'user_email' => $user_email
        ]);
    }

    public function index()
    {
        try {
            $tickets = $this->jiraServiceDeskService->getCustomerTickets(Auth::user()->email)->issues;
        } catch (ServiceDeskException $e) {
            return back()->with('error', $e->getMessage())->withInput();
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
            return back()->with('error', $e->getMessage())->withInput();
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
            'raiseOnBehalfOf' => Auth::user()->email
        ];
        try {
            $this->jiraServiceDeskService->addComment($issueKey, $data);
        } catch (ServiceDeskException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }

        return redirect()->route('tickets.menu')->with('success', 'Comment has been added!');
    }
}
