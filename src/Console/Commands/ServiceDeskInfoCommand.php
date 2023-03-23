<?php

namespace TianSchutte\ServiceDeskJira\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use TianSchutte\ServiceDeskJira\Services\ServiceDeskService;

/**
 * @package MailWizzSync
 * @licence Giant Outsourcing
 * @author: Tian Schutte
 */
class ServiceDeskInfoCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'service-desk:info';

    /**
     * @var string
     */
    protected $description = 'Display information about the package\'s configuration and status';

    /**
     * @var ServiceDeskService
     */
    private $jiraServiceDeskService;

    /**
     * @param ServiceDeskService $jiraServiceDeskService
     */
    public function __construct(ServiceDeskService $jiraServiceDeskService)
    {
        parent::__construct();
        $this->jiraServiceDeskService = $jiraServiceDeskService;
    }

    /**
     * @return void
     */
    public function handle()
    {
        try {

            $info = $this->jiraServiceDeskService->getInfo();
            $serviceDeskInfo = $this->jiraServiceDeskService->getServiceDesk();

            $this->info('Jira Service Desk Info:');
            $this->line('- Version: ' . $info->version);
            $this->line('- Build Date: ' . $info->buildDate->friendly);
            $this->line('- Project Id: ' . $serviceDeskInfo->id);
            $this->line('- Project Name: ' . $serviceDeskInfo->projectName . ' (' . $serviceDeskInfo->projectKey . ')');

            $this->info('API Info:');
            $this->line('- API Url: ' . config('service-desk-jira.base_url'));
            $this->line('- API Email: ' . config('service-desk-jira.email'));
            $this->line('- API Key: ' . str_repeat('*', strlen(config('service-desk-jira.api_key'))));
        } catch (Exception $e) {
            $this->error($e);
        }
    }

}
