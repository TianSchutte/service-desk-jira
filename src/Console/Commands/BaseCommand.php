<?php

namespace TianSchutte\ServiceDeskJira\Console\Commands;

use Illuminate\Console\Command;

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

    public function __construct()
    {
        parent::__construct();
        $this->project_id = config('service-desk-jira.project_id');
        $this->jiraServiceDeskService = app('service-desk-jira');

    }
    public function handle()
    {
//        $requestFieldValues = [
//            "serviceDeskId" => "6",
//            "requestTypeId" => "88",
//            "requestFieldValues" => [
//                "summary" => "mmmmmmm",
////                "customfield_10003"=> "62e7abf83cc20c06c8ae1849",
//                "description" => "mmmmm"
//            ]
//        ];

        try {
//            $response =  $this->jiraServiceDeskService->getUserTickets('tian@giantprocurement.guru');
            $response =  $this->jiraServiceDeskService->getTypes(1);
            dd($response);
        } catch (\Exception $e) {
            $this->error($e);
        }

    }

}
