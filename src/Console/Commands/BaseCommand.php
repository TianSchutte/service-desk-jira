<?php

namespace TianSchutte\ServiceDeskJira\Console\Commands;

use Illuminate\Console\Command;
use TianSchutte\ServiceDeskJira\Services\ServiceDeskService;

/**
 * @package MailWizzSync
 * @licence Giant Outsourcing
 * @author: Tian Schutte
 */
class BaseCommand extends Command
{
    protected $signature = 'sdj:test';

    protected $description = 'test';
    private $project_id;

    private $jiraServiceDeskService;

    public function __construct(ServiceDeskService $jiraServiceDeskService)
    {
        parent::__construct();
        $this->project_id = config('service-desk-jira.project_id');
        $this->jiraServiceDeskService = $jiraServiceDeskService;
    }

    public function handle()
    {
        try {
//            $response =  $this->jiraServiceDeskService->getUserTickets('tian@giantprocurement.guru');
            $response = $this->jiraServiceDeskService->getTypeGroup('tian@giantprocurement.guru');
//            $response = $this->jiraServiceDeskService->getTypeById('31');
            dd($response);
        } catch (\Exception $e) {
            $this->error($e);
        }
    }

}
