<?php

namespace TianSchutte\ServiceDeskJira\Services;

use GuzzleHttp\Client;
use TianSchutte\ServiceDeskJira\Contracts\DeskManagerInterface;
use TianSchutte\ServiceDeskJira\Contracts\IssueManagerInterface;
use TianSchutte\ServiceDeskJira\Contracts\TicketManagerInterface;
use TianSchutte\ServiceDeskJira\Traits\DeskManagerTrait;
use TianSchutte\ServiceDeskJira\Traits\IssueManagerTrait;
use TianSchutte\ServiceDeskJira\Traits\TicketManagerTrait;

class JiraServiceDeskService implements IssueManagerInterface, DeskManagerInterface, TicketManagerInterface
{
    use IssueManagerTrait;
    use DeskManagerTrait;
    use TicketManagerTrait;

    protected $client;
    protected $project_id;

    public function __construct($baseUrl, $email, $apiKey)
    {
        $this->client = new Client([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
//            'X-Atlassian-Token'=>'no-check',
//            'X-XSRF-Token'=>'no-check',
            'X-ExperimentalApi' => 'opt-in',
            'base_uri' => $baseUrl,
            'auth' => [$email, $apiKey],
        ]);

        $this->project_id = config('service-desk-jira.project_id');
    }
}
