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
//            $response = JiraServiceDeskFacade::getUserTickets('tian@giantprocurement.guru');
//            dd($response);
        } catch (\Exception $e) {
            $this->error($e);
        }

    }

}
