<?php

namespace TianSchutte\ServiceDeskJira\Facades;

use Illuminate\Support\Facades\Facade;

class JiraServiceDeskFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'service-desk-jira';
    }
}
