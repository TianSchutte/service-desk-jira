<?php

namespace TianSchutte\ServiceDeskJira\Console\Commands;

use Exception;
use GuzzleHttp\Psr7\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use TianSchutte\ServiceDeskJira\Services\ServiceDeskService;

/**
 * @package MailWizzSync
 * @licence Giant Outsourcing
 * @author: Tian Schutte
 */
class ListTicketsByEmailCommand extends Command
{
    protected $signature = 'service-desk:list-tickets {customerEmail}';

    protected $description = 'List all tickets submitted by the given user in Jira Service Desk.';

    private $jiraServiceDeskService;

    public function __construct(ServiceDeskService $jiraServiceDeskService)
    {
        parent::__construct();
        $this->jiraServiceDeskService = $jiraServiceDeskService;
    }

    public function handle()
    {
        try {
            $customerEmail = $this->argument('customerEmail');

            $issues = $this->jiraServiceDeskService->getCustomerTickets($customerEmail)->issues;

            if (count($issues) > 0) {
                $this->info($customerEmail.'\'s Jira Service Desk Tickets:');
                foreach ($issues as $issue) {
                    $this->line('- ' . $issue->key . ': ' . $issue->fields->summary);
                }
            } else {
                $this->info('They have not submitted any tickets to Jira Service Desk.');
            }
        } catch (Exception $e) {
            $this->error($e);
        }
    }

}
