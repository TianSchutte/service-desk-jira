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

//        $info = JiraServiceDeskFacade::getInfo();
        $serviceDesks = JiraServiceDeskFacade::getServiceDesks();
        $curServiceDeskId = $serviceDesks->values;
////        $serviceDesk0 = JiraServiceDeskFacade::getServiceDeskById($curServiceDeskId);
//        $serviceForm = JiraServiceDeskFacade::getTypes($curServiceDeskId);
//        $serviceFormFields = JiraServiceDeskFacade::getFields($curServiceDeskId, $serviceForm->values[0]->id);

//        $queues = JiraServiceDeskFacade::getQueues($serviceDesks->values[0]->id);


//         print_r($info);
//         print_r($curServiceDeskId);

//        $test = JiraServiceDeskFacade::getCustomFieldData('customfield_10003');
//        $test = JiraServiceDeskFacade::getCustomFieldData('customfield_10003');

//        $requestTypeId = 89;
//        $fieldValues = [
//            "summary" => "asdasd",
//            "description" => "asdasd",
//            "customfield_10051" => "ari:cloud:graph::service/6aaef651-21e0-4543-be26-3094e9b5ba76/be481e02-3b31-11ed-b339-128b42819424",
//            "customfield_10049" => "10025",
//            "customfield_10004" => "10000",
//        ];
//        $body = <<<REQUESTBODY
//{
//  "adfRequest": false,
//  "requestFieldValues": {
//    "description": "I need a new *mouse* for my Mac",
//    "summary": "Request JSD help via REST"
//  },
//  "requestTypeId": "88",
//  "serviceDeskId": "6"
//}
//REQUESTBODY;
        $requestFieldValues = [
            "serviceDeskId" => "6",
            "requestTypeId" => "88",
            "requestFieldValues" => [
                "summary" => "mmmmmmm",
//                "customfield_10003"=> "62e7abf83cc20c06c8ae1849",

                "description" => "mmmmm"
            ]
        ];

        try {
            $request = JiraServiceDeskFacade::createIssue($requestFieldValues);
            $this->info($request);
        } catch (\Exception $e) {
            $this->error($e);
        }

    }

}
