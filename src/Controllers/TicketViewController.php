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

class TicketViewController
{
    /**
     * @var ServiceDeskService
     */
    private $jiraServiceDeskService;

    /**
     * TicketViewController constructor.
     * @param ServiceDeskService $jiraServiceDeskService
     */
    public function __construct(ServiceDeskService $jiraServiceDeskService)
    {
        $this->jiraServiceDeskService = $jiraServiceDeskService;
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
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

    /**
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
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
        $request->validate([
            'issue_key' => 'required',
            'comment_body' => 'required'
        ]);

        $issueKey = $request->input('issue_key');
        $commentBody = $request->input('comment_body');

        $data = [
            'body' => Auth::user()->email . ' : ' . $commentBody,
            'public' => true,
//            'raiseOnBehalfOf' => Auth::user()->email //todo this functionality is not included in jira for this endpoint
        ];
        try {
            $this->jiraServiceDeskService->addComment($issueKey, $data);
        } catch (ServiceDeskException $e) {
            return redirect()->route('tickets.view.index')->with('error', $e->getMessage());
        }

        return redirect()->route('tickets.menu')->with('success', 'Comment has been added!');
    }
}
