<?php

namespace TianSchutte\ServiceDeskJira\Console\Commands;

use Illuminate\Console\Command;
use TianSchutte\ServiceDeskJira\Facades\JiraServiceDeskFacade;

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
            $request = JiraServiceDeskFacade::getInfo();
            $this->info($request);
        } catch (\Exception $e) {
            $this->error($e);
        }

    }

}
