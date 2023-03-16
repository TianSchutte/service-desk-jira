<?php

namespace TianSchutte\ServiceDeskJira\Services;

use GuzzleHttp\Client;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use TianSchutte\ServiceDeskJira\Contracts\DeskManagerInterface;
use TianSchutte\ServiceDeskJira\Contracts\IssueManagerInterface;
use TianSchutte\ServiceDeskJira\Contracts\TypeManagerInterface;
use TianSchutte\ServiceDeskJira\Contracts\UtilityManagerInterface;
use TianSchutte\ServiceDeskJira\Traits\DeskManagerTrait;
use TianSchutte\ServiceDeskJira\Traits\IssueManagerTrait;
use TianSchutte\ServiceDeskJira\Traits\TypeManagerTrait;
use TianSchutte\ServiceDeskJira\Traits\UtilityManagerTrait;

class JiraServiceDeskService implements IssueManagerInterface, DeskManagerInterface, TypeManagerInterface, UtilityManagerInterface
{
    use IssueManagerTrait;
    use DeskManagerTrait;
    use TypeManagerTrait;
    use UtilityManagerTrait;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var mixed
     */
    protected $project_id;

    /**
     * @param $baseUrl
     * @param $email
     * @param $apiKey
     */
    public function __construct($baseUrl, $email, $apiKey)
    {
        $this->client = new Client([
            'Accept' => 'application/json',
//            'http_errors' => false,
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
