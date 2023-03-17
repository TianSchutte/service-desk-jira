<?php

namespace TianSchutte\ServiceDeskJira\Contracts;

interface DeskManagerInterface
{
    public function getInfo();

    public function getServiceDesks();

    public function getServiceDeskById($serviceDeskId);

    public function getQueues();

    public function getIssuesInQueue($queueId);

}
