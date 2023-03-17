<?php

namespace TianSchutte\ServiceDeskJira\Services;

use GuzzleHttp\Client;
use TianSchutte\ServiceDeskJira\Contracts\CustomerManagerInterface;
use TianSchutte\ServiceDeskJira\Contracts\DeskManagerInterface;
use TianSchutte\ServiceDeskJira\Contracts\IssueManagerInterface;
use TianSchutte\ServiceDeskJira\Contracts\TypeManagerInterface;
use TianSchutte\ServiceDeskJira\Contracts\UtilityManagerInterface;
use TianSchutte\ServiceDeskJira\Traits\CustomerManagerTrait;
use TianSchutte\ServiceDeskJira\Traits\DeskManagerTrait;
use TianSchutte\ServiceDeskJira\Traits\IssueManagerTrait;
use TianSchutte\ServiceDeskJira\Traits\TypeManagerTrait;
use TianSchutte\ServiceDeskJira\Traits\UtilityManagerTrait;

class ServiceDeskService implements
    IssueManagerInterface,
    DeskManagerInterface,
    TypeManagerInterface,
    CustomerManagerInterface,
    UtilityManagerInterface
{
    use IssueManagerTrait;
    use DeskManagerTrait;
    use TypeManagerTrait;
    use CustomerManagerTrait;
    use UtilityManagerTrait;


    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string|int|mixed
     */
    protected $serviceDeskId;

    /**
     * JiraServiceDeskService constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
//            'X-Atlassian-Token'=>'no-check',
//            'X-XSRF-Token'=>'no-check',
            'X-ExperimentalApi' => 'opt-in',
            'base_uri' => config('service-desk-jira.base_url'),
            'auth' =>
                [
                    config('service-desk-jira.email'),
                    config('service-desk-jira.api_key')
                ],
        ]);

        $this->serviceDeskId = config('service-desk-jira.project_id');
    }
}
