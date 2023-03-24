<?php

namespace TianSchutte\ServiceDeskJira\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use TianSchutte\ServiceDeskJira\Services\ServiceDeskService;

class ListTicketsByEmailCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'service-desk:list-tickets {customerEmail}';

    /**
     * @var string
     */
    protected $description = 'List all tickets submitted by the given user in Jira Service Desk.';

    /**
     * @var ServiceDeskService
     */
    private $serviceDesk;

    /**
     * @param ServiceDeskService $serviceDeskService
     */
    public function __construct(ServiceDeskService $serviceDeskService)
    {
        parent::__construct();
        $this->serviceDesk = $serviceDeskService;
    }

    /**
     * @return void
     */
    public function handle()
    {
        try {
            $customerEmail = $this->argument('customerEmail');

            $issues = $this->serviceDesk->getCustomerTickets($customerEmail)->issues;

            if (count($issues) > 0) {
                $this->info($customerEmail . '\'s Jira Service Desk Tickets:');
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
