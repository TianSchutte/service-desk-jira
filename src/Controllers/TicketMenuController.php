<?php

namespace TianSchutte\ServiceDeskJira\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class TicketMenuController
{

    /**
     * @return Application|Factory|View
     */
    public function index()
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
}