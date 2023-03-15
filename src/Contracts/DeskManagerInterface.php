<?php

namespace TianSchutte\ServiceDeskJira\Contracts;

interface DeskManagerInterface
{
    public function getInfo();

    public function getServiceDesks();

    public function getServiceDeskById($serviceDeskId);

    public function getQueues($serviceDeskId);

    public function getIssuesInQueue($serviceDeskId, $queueId);
}
